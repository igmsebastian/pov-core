<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Knuckles\Scribe\Attributes\Group;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;

#[Group("01 - Auth API Resources")]
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
