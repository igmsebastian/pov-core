<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use App\Http\Resources\User\UserResource;
use Illuminate\Auth\AuthenticationException;
use Knuckles\Scribe\Attributes\ResponseFromFile;
use Illuminate\Auth\Access\AuthorizationException;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Header;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("Authentication", "APIs for authentication")]
class AuthController extends Controller
{
    use ListensForLdapBindFailure;

    public function __construct(private AuthService $authService)
    {
    }

    /**
     * Issue a new access token.
     *
     * Authenticates the incoming request (e.g. LDAP bind or credentials)
     * and returns a fresh Sanctum token.
     */
    #[Header("Accept", "application/json")]
    #[ResponseFromFile("storage/responses/auth/token.get.json")]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 404, description: 'Not Found', content: '{"message": "Not found."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getAccessToken(Request $request)
    {
        return $this->authService->getAccessToken($request);
    }

    /**
     * Fetch the current user.
     *
     * Returns the profile of the user associated with the provided token.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(UserResource::class, User::class)]
    #[Response(status: 400, description: 'Bad Request', content: '{"message": "Bad Request."}')]
    #[Response(status: 401, description: "Unauthorized", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response( status: 404, description: 'Not Found', content: '{"message": "Not found."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getAuthenticatedUser(Request $request)
    {
        return $this->authService->getMe($request);
    }
}
