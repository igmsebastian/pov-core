<?php

namespace Database\Seeders\Defaults;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'samaccountname' => 'ian.sebastian',
            ],
            [
                'samaccountname' => 'paolo.maico',
            ],
            [
                'samaccountname' => 'joar.donceras',
            ],
            [
                'samaccountname' => 'ricardo.liera',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['samaccountname' => $user['samaccountname']],
                ['samaccountname' => $user['samaccountname'], 'role_id' => RoleEnum::ADMIN]
            );
        }
    }
}
