<?php

namespace App\Services\Concerns;

use App\Models\User;
use App\Facades\LdapConnect;
use Illuminate\Support\Facades\Auth;

trait HandlesAuthenticator
{
    public function getUserLdapAuthenticator(): User
    {
        if (Auth::guard()->name === 'web') {
            if ($user = Auth::user()) {
                return $user;
            }
        }

        return LdapConnect::connect();
    }
}