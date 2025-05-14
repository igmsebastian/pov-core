<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;

class AuthController extends Controller
{
    use ListensForLdapBindFailure;

    public function __construct(private AuthService $authService)
    {
    }

    public function getAccessToken(Request $request)
    {
        return $this->authService->getAccessToken($request);
    }
}
