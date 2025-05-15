<?php

namespace Database\Seeders\Defaults;

use App\Models\Role;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'System administrator with full access.',
            ],
            [
                'name' => 'manager',
                'description' => 'Manager with access to oversee processes and teams.',
            ],
            [
                'name' => 'user',
                'description' => 'Standard user with limited permissions.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
