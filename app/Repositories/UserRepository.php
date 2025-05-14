<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function fetchClient(): object
    {
        return DB::table('oauth_clients')
            ->where('password_client', true)
            ->get()[0];
    }

    public function fetchAll($filters): Collection
    {
        return User::filters($filters)->get();
    }

    public function findUserByEmail(string $email): User|null
    {
        return User::firstWhere($email);
    }

    public function create(array $data): Collection
    {
        return User::create($data);
    }
}