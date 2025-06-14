<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\LdapUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserRepository;
use LdapRecord\Container as AdContainer;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Auth\TokenResource;
use App\Services\Concerns\HandlesAuthenticator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpFoundation\Exception\UnexpectedValueException;

class AuthService extends Service
{
    use HandlesAuthenticator;

    public function __construct(
        private UserRepository $userRepository,
    ) {}

    public function getMe(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function isLdapAvailable(): bool
    {
        try {
            AdContainer::getDefaultConnection()->connect();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getLogonUser(?string $logonUser): User
    {
        if (config('ldap.enabled') === true) {
            if (is_null($logonUser)) {
                throw new UnauthorizedHttpException("No authenticated user found");
            }

            if (!str_contains($logonUser, '\\')) {
                throw new UnexpectedValueException("Invalid LOGON_USER format");
            }

            [$domain, $username] = explode('\\', $logonUser);

            $user = $this->requireLdapSync($username);
        } else {
            $logonUser = config('ldap.test.samaccountname');
            $user = $this->userRepository->findUserBySamaccountname($logonUser);
        }

        return $user;
    }

    public function requireLdapSync(string $samaccountname)
    {
        $ldapUser = LdapUser::firstWhere('samaccountname', $samaccountname);

        if (is_null($ldapUser)) {
            throw new NotFoundHttpException("LDAP user not found: $samaccountname");
        }

        return $this->userRepository->syncLdapUser($ldapUser);
    }

    public function getAccessToken(Request $request)
    {
        // Retrieve the LOGON_USER from the request server data
        $logonUser = $request->server('LOGON_USER');

        // Get the user based on the LOGON_USER, which could be null if not found
        $user = $this->getLogonUser($logonUser);

        // If user not found, return a "not found" response
        if (is_null($user)) {
            return $this->sendNotFoundResponse('User not found or could not be synced');
        }

        // Delete existing tokens
        if ($user->tokens()->exists()) {
            $user->tokens()->delete();
        }

        $user->tokens()->delete();

        // Create a token for the user (Sanctum token)
        $token = $user->createToken('Access Token', $user->configs['permissions']);

        // Check if the request expects JSON or not
        if (!$request->wantsJson()) {
            $url = session('urlreferer') ?: config('app.url_front');
            return redirect()->away("{$url}?token={$token->plainTextToken}");
        }

        // If JSON response is needed, return the token within a structured response
        return new TokenResource($token);
    }

    public function revokeAccessToken(Request $request): JsonResponse
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        return is_null($token)
            ? $user->tokens()->delete()
            : $token->delete();

        return $this->sendOkResponse();
    }
}
