<?php

namespace Database\Seeders\Defaults;

use App\Models\Module;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define users to seed
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
            [
                'samaccountname' => 'martin.gamboa',
            ],
        ];

        // Fetch all permissions for the Admin-like access (or specific permissions you want)
        $adminPermissions = Permission::where('action', '*') // Filter by '*' action
            ->get()
            ->map(function ($permission) {
                return $permission->resource . ':' . $permission->action; // Combine resource and action
            })
            ->toArray();

        $modules = Module::get()->pluck('code')->toArray();

        // Add User Module for User Management
        $modules[] = 'user';

        // Loop through each user and assign permissions directly
        foreach ($users as $user) {
            // Create or update the user with the permissions in the configs field
            $userModel = User::updateOrCreate(
                ['samaccountname' => $user['samaccountname']],
                [
                    'samaccountname' => $user['samaccountname'],
                    'configs' => [
                        'permissions' => $adminPermissions, // Store all permissions directly in the configs
                        'modules' => $modules, // Store all permissions directly in the configs
                    ]
                ]
            );
        }
    }
}
