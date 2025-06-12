<?php

namespace Database\Seeders\Defaults;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'user', 'description' => 'Manage users'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'user', 'description' => 'Create users'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'user', 'description' => 'Edit users'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'user', 'description' => 'Delete users'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'user', 'description' => 'View users'],

            // Template Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'template', 'description' => 'Manage templates'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'template', 'description' => 'Create templates'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'template', 'description' => 'Edit templates'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'template', 'description' => 'Delete templates'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'template', 'description' => 'View templates'],

            // Process Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'process', 'description' => 'Manage processes'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'process', 'description' => 'Create processes'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'process', 'description' => 'Edit processes'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'process', 'description' => 'Delete processes'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'process', 'description' => 'View processes'],

            // Sub Process Management  permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'subprocess', 'description' => 'Manage subprocesses'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'subprocess', 'description' => 'Create subprocesses'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'subprocess', 'description' => 'Edit subprocesses'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'subprocess', 'description' => 'Delete subprocesses'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'subprocess', 'description' => 'View subprocesses'],

            // Task Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'task', 'description' => 'Manage tasks'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'task', 'description' => 'Create tasks'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'task', 'description' => 'Edit tasks'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'task', 'description' => 'Delete tasks'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'task', 'description' => 'View tasks'],

            // Module / Application Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'module', 'description' => 'Manage modules'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'module', 'description' => 'Create modules'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'module', 'description' => 'Edit modules'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'module', 'description' => 'Delete modules'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'module', 'description' => 'View modules'],

            // Feature / Service Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'feature', 'description' => 'Manage features'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'feature', 'description' => 'Create features'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'feature', 'description' => 'Edit features'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'feature', 'description' => 'Delete features'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'feature', 'description' => 'View features'],

            // Report Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'report', 'description' => 'Manage reports'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'report', 'description' => 'Create reports'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'report', 'description' => 'Edit reports'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'report', 'description' => 'Delete reports'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'report', 'description' => 'View reports'],

            // Mail Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'mail', 'description' => 'Manage mail'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'mail', 'description' => 'Create mail'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'mail', 'description' => 'Edit mail'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'mail', 'description' => 'Delete mail'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'mail', 'description' => 'View mail'],
            ['category' => 'pov', 'action' => 'send', 'resource' => 'mail', 'description' => 'Send mail'],

            // Notification Management permissions
            ['category' => 'pov', 'action' => 'manage', 'resource' => 'notification', 'description' => 'Manage notifications'],
            ['category' => 'pov', 'action' => 'create', 'resource' => 'notification', 'description' => 'Create notifications'],
            ['category' => 'pov', 'action' => 'edit', 'resource' => 'notification', 'description' => 'Edit notifications'],
            ['category' => 'pov', 'action' => 'delete', 'resource' => 'notification', 'description' => 'Delete notifications'],
            ['category' => 'pov', 'action' => 'view', 'resource' => 'notification', 'description' => 'View notifications'],
            ['category' => 'pov', 'action' => 'send', 'resource' => 'notification', 'description' => 'Send notifications'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['action' => $permission['action'], 'resource' => $permission['resource']],
                ['description' => $permission['description']]
            );
        }

        // Define Roles
        $roles = [
            [
                'name' => 'admin',
                'description' => 'System administrator with full access.',
                'permissions' => Permission::all()->pluck('id')->toArray(),
            ],
            [
                'name' => 'manager',
                'description' => 'Manager with access to oversee processes and teams.',
                'permissions' => Permission::where('action', 'manage')->pluck('id')->toArray(),
            ],
            [
                'name' => 'user',
                'description' => 'Standard user with limited permissions.',
                'permissions' => Permission::whereIn('action', ['create', 'edit', 'view', 'send'])->pluck('id')->toArray(),
            ],
        ];

        // Seed Roles and Attach Permissions
        foreach ($roles as $roleData) {
            // Create or update the role
            $role = Role::updateOrCreate(
                ['name' => $roleData['name']],
                ['description' => $roleData['description'], 'created_by' => 'default']
            );

            // Attach permissions to the role
            $role->permissions()->sync($roleData['permissions']); // Use sync to attach the correct permissions
        }
    }
}
