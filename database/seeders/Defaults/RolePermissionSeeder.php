<?php

namespace Database\Seeders\Defaults;

use App\Models\Role;
use App\Models\Module;
use App\Models\Permission;
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
            // Super Admin permissions
            ['category' => '*', 'resource' => '*', 'action' => '*', 'description' => 'Super-Admin: full access to everything'],
            ['category' => 'pov', 'resource' => '*', 'action' => '*', 'description' => 'Admin: full access to pov'],

            // User Management permissions
            ['category' => 'pov', 'resource' => 'user', 'action' => '*', 'description' => 'Full access to user management'],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'create', 'description' => 'Create users'],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'edit', 'description' => 'Edit users'],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'delete', 'description' => 'Delete users'],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'view', 'description' => 'View users'],

            // Template Management permissions
            ['category' => 'pov', 'resource' => 'template', 'action' => '*', 'description' => 'Full access to template management'],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'create', 'description' => 'Create templates'],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'edit', 'description' => 'Edit templates'],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'delete', 'description' => 'Delete templates'],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'view', 'description' => 'View templates'],

            // Process Management permissions
            ['category' => 'pov', 'resource' => 'process', 'action' => '*', 'description' => 'Full access to process management'],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'create', 'description' => 'Create processes'],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'edit', 'description' => 'Edit processes'],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'delete', 'description' => 'Delete processes'],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'view', 'description' => 'View processes'],

            // Sub Process Management  permissions
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => '*', 'description' => 'Full access to subprocess management'],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'create', 'description' => 'Create subprocesses'],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'edit', 'description' => 'Edit subprocesses'],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'delete', 'description' => 'Delete subprocesses'],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'view', 'description' => 'View subprocesses'],

            // Task Management permissions
            ['category' => 'pov', 'resource' => 'task', 'action' => '*', 'description' => 'Full access to task management'],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'create', 'description' => 'Create tasks'],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'edit', 'description' => 'Edit tasks'],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'delete', 'description' => 'Delete tasks'],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'view', 'description' => 'View tasks'],

            // Module / Application Management permissions
            ['category' => 'pov', 'resource' => 'module', 'action' => '*', 'description' => 'Full access to module management'],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'create', 'description' => 'Create modules'],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'edit', 'description' => 'Edit modules'],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'delete', 'description' => 'Delete modules'],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'view', 'description' => 'View modules'],

            // Feature / Service Management permissions
            ['category' => 'pov', 'resource' => 'feature', 'action' => '*', 'description' => 'Full access to feature management'],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'create', 'description' => 'Create features'],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'edit', 'description' => 'Edit features'],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'delete', 'description' => 'Delete features'],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'view', 'description' => 'View features'],

            // Report Management permissions
            ['category' => 'pov', 'resource' => 'report', 'action' => '*', 'description' => 'Full access to report management'],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'create', 'description' => 'Create reports'],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'edit', 'description' => 'Edit reports'],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'delete', 'description' => 'Delete reports'],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'view', 'description' => 'View reports'],

            // Mail Management permissions
            ['category' => 'pov', 'resource' => 'mail', 'action' => '*', 'description' => 'Full access to mail management'],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'create', 'description' => 'Create mail'],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'edit', 'description' => 'Edit mail'],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'delete', 'description' => 'Delete mail'],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'view', 'description' => 'View mail'],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'receive', 'description' => 'Receive mail'],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'send', 'description' => 'Send mail'],

            // Notification Management permissions
            ['category' => 'pov', 'resource' => 'notification', 'action' => '*', 'description' => 'Full access to notification management'],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'create', 'description' => 'Create notifications'],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'edit', 'description' => 'Edit notifications'],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'delete', 'description' => 'Delete notifications'],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'view', 'description' => 'View notifications'],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'receive', 'description' => 'Receive notifications'],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'send', 'description' => 'Send notifications'],
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

        // MODULE
        $modules = [
            ['country' => '*', 'name' => 'Admin', 'code' => 'admin'],
            ['country' => '*', 'name' => 'User', 'code' => 'user'],
        ];

        foreach ($modules as $module) {
            $module = Module::updateOrCreate(
                ['country' => '*', 'code' => $module['code']],
                $module
            );
        }
    }
}
