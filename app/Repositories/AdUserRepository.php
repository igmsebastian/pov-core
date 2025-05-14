<?php

namespace App\Repositories;

use LdapRecord\Models\Model;
use LdapRecord\Models\ActiveDirectory\User as ADUser;

class AdUserRepository
{
    public function findAdUserByMail(string $email): ?Model
    {
        return ADUser::where('mail', $email)->first();
    }

    public function findAdUserByGuid(string $guid): ?Model
    {
        return ADUser::findByGuid($guid);
    }
}