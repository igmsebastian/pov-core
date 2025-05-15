<?php

namespace Database\Seeders\Defaults;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Application-level permissions
            ['action' => 'view',    'resource' => 'Module',     'description' => 'View modules'],
            ['action' => 'create',  'resource' => 'Module',     'description' => 'Create modules'],
            ['action' => 'edit',    'resource' => 'Module',     'description' => 'Edit modules'],
            ['action' => 'delete',  'resource' => 'Module',     'description' => 'Delete modules'],

            // Process-level permissions
            ['action' => 'view',    'resource' => 'Process',    'description' => 'View processes'],
            ['action' => 'create',  'resource' => 'Process',    'description' => 'Create processes'],
            ['action' => 'edit',    'resource' => 'Process',    'description' => 'Edit processes'],
            ['action' => 'delete',  'resource' => 'Process',    'description' => 'Delete processes'],

            // SubProcess-level
            ['action' => 'view',    'resource' => 'SubProcess',     'description' => 'View subprocesses'],
            ['action' => 'create',  'resource' => 'SubProcess',     'description' => 'Create subprocesses'],
            ['action' => 'edit',    'resource' => 'SubProcess',     'description' => 'Edit subprocesses'],
            ['action' => 'delete',  'resource' => 'SubProcess',     'description' => 'Delete subprocesses'],

            // Task-level
            ['action' => 'view',    'resource' => 'Task',     'description' => 'View tasks'],
            ['action' => 'create',  'resource' => 'Task',     'description' => 'Create tasks'],
            ['action' => 'edit',    'resource' => 'Task',     'description' => 'Edit tasks'],
            ['action' => 'delete',  'resource' => 'Task',     'description' => 'Delete tasks'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['action' => $perm['action'], 'resource' => $perm['resource']],
                ['description' => $perm['description']]
            );
        }
    }
}
