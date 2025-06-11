<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\LdapUser;
use Illuminate\Http\Request;
use App\Http\Resources\AuthResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Http;
use LdapRecord\Container as AdContainer;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Auth\LoginResource;
use App\Services\Concerns\HandlesAuthenticator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthService extends Service
{
    use HandlesAuthenticator;

    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

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

    public function getUserByLogonUser(string $logonUser): User
    {
        if (config('ldap.enabled') === true) {
            if (!str_contains($logonUser, '\\')) {
                throw new \InvalidArgumentException("Invalid LOGON_USER format");
            }
    
            [$domain, $username] = explode('\\', $logonUser);

            $ldapUser = LdapUser::where('samaccountname', $username)->first();

            if (!$ldapUser) {
                throw new NotFoundHttpException("LDAP user not found for email: $email");
            }

            $user = $this->userRepository->syncLdapUser($ldapUser);
        } else {
            $user = $this->userRepository->findUserByEmail($logonUser);
        }

        return $user;
    }

    public function getAccessToken(Request $request)
    {
        $logonUser = request()->server('LOGON_USER');

        if (!$logonUser) {
            $this->sendUnauthenticatedResponse('No authenticated user found');
        }

        $user = $this->getUserByLogonUser($logonUser);

        if (is_null($user)) {
            return $this->sendNotFoundResponse('User not found or could not be synced');
        }

        $tokenResult = $user->createToken('SSO Token');
        $token = $tokenResult->accessToken;
        $expiresAt = $tokenResult->token->expires_at;

        dd($tokenResult);

        if ($response->failed()) {
            return $this->sendUnauthenticatedResponse('Token request failed');
        }

        dd($response->json());

        $token = $user->createToken('SSO Token')->accessToken;

        if (!$request->wantsJson()) {
            $url = session('urlreferer') ?: config('app.url_front');
            return redirect()->away("{$url}?token={$token}");
        }

        return new LoginResource($response);
    }

    public function getRefreshToken(Request $request)
    {
        $response = Http::asForm()->post(url('/oauth/token'), [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => config('passport.password_client_id'),
            'client_secret' => config('passport.password_client_secret'),
            'scope' => '',
        ]);

        if ($response->failed()) {
            return $this->sendUnauthenticatedResponse("Unable to refresh token");
        }

        dd($response);

        // return new AuthResource($response);
    }
}
