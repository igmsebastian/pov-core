<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AuthResource;
use App\Repositories\UserRepository;
use LdapRecord\Container as AdContainer;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Auth\LoginResource;
use App\Services\Concerns\HandlesAuthenticator;

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

    public function getAccessToken(Request $request)
    {
        $client = $this->userRepository->fetchClient();

        $user = (config('ldap.enabled') == true)
                ? $this->getUserLdapAuthenticator()
                : $this->userRepository->findUserByEmail(config('ldap.test.email'));

        $requestToken = Request::create(url('/oauth/token'), 'POST', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $user->email,
            'password' => 'password',
            'scope' => ''
        ]);

        $response = $this->getResponse($requestToken);

        if (!$request->wantsJson()) {
			$url = session('urlreferer')
                ? session('urlreferer').'auth/sso/redirect'
                : config('pov.auth_redirect_url');

            $params = http_build_query($response);

            return redirect()->away("{$url}?{$params}");
        }

        $response->user = $user;

        return new LoginResource($response);
    }

    public function getRefreshToken(Request $request): AuthResource
    {
        $client = $this->userRepository->fetchClient();

        $request = Request::create(url('/oauth/token'), 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => ''
        ]);

        return new AuthResource($this->getResponse($request));
    }
}