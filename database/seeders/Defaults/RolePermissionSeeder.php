<?php

namespace Database\Seeders\Defaults;

use App\Models\Role;
use App\Models\Module;
use App\Models\Feature;
use App\Models\Permission;
use App\Enums\FeatureTypeEnum;
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
            ['category' => '*', 'resource' => '*', 'action' => '*', 'description' => 'Super-Admin: full access to everything', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => '*', 'action' => '*', 'description' => 'Admin: full access to pov', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // User Management permissions
            ['category' => 'pov', 'resource' => 'user', 'action' => '*', 'description' => 'Full access to user management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'create', 'description' => 'Create users', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'edit', 'description' => 'Edit users', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'delete', 'description' => 'Delete users', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'user', 'action' => 'view', 'description' => 'View users', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Template Management permissions
            ['category' => 'pov', 'resource' => 'template', 'action' => '*', 'description' => 'Full access to template management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'create', 'description' => 'Create templates', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'edit', 'description' => 'Edit templates', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'delete', 'description' => 'Delete templates', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'template', 'action' => 'view', 'description' => 'View templates', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Process Management permissions
            ['category' => 'pov', 'resource' => 'process', 'action' => '*', 'description' => 'Full access to process management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'create', 'description' => 'Create processes', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'edit', 'description' => 'Edit processes', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'delete', 'description' => 'Delete processes', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'process', 'action' => 'view', 'description' => 'View processes', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Sub Process Management  permissions
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => '*', 'description' => 'Full access to subprocess management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'create', 'description' => 'Create subprocesses', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'edit', 'description' => 'Edit subprocesses', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'delete', 'description' => 'Delete subprocesses', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'subprocess', 'action' => 'view', 'description' => 'View subprocesses', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Task Management permissions
            ['category' => 'pov', 'resource' => 'task', 'action' => '*', 'description' => 'Full access to task management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'create', 'description' => 'Create tasks', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'edit', 'description' => 'Edit tasks', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'delete', 'description' => 'Delete tasks', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'task', 'action' => 'view', 'description' => 'View tasks', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Module / Application Management permissions
            ['category' => 'pov', 'resource' => 'module', 'action' => '*', 'description' => 'Full access to module management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'create', 'description' => 'Create modules', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'edit', 'description' => 'Edit modules', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'delete', 'description' => 'Delete modules', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'module', 'action' => 'view', 'description' => 'View modules', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Feature / Service Management permissions
            ['category' => 'pov', 'resource' => 'feature', 'action' => '*', 'description' => 'Full access to feature management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'create', 'description' => 'Create features', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'edit', 'description' => 'Edit features', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'delete', 'description' => 'Delete features', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'feature', 'action' => 'view', 'description' => 'View features', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Report Management permissions
            ['category' => 'pov', 'resource' => 'report', 'action' => '*', 'description' => 'Full access to report management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'create', 'description' => 'Create reports', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'edit', 'description' => 'Edit reports', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'delete', 'description' => 'Delete reports', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'report', 'action' => 'view', 'description' => 'View reports', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Mail Management permissions
            ['category' => 'pov', 'resource' => 'mail', 'action' => '*', 'description' => 'Full access to mail management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'create', 'description' => 'Create mail', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'edit', 'description' => 'Edit mail', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'delete', 'description' => 'Delete mail', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'view', 'description' => 'View mail', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'receive', 'description' => 'Receive mail', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'mail', 'action' => 'send', 'description' => 'Send mail', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],

            // Notification Management permissions
            ['category' => 'pov', 'resource' => 'notification', 'action' => '*', 'description' => 'Full access to notification management', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'create', 'description' => 'Create notifications', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'edit', 'description' => 'Edit notifications', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'delete', 'description' => 'Delete notifications', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'view', 'description' => 'View notifications', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'receive', 'description' => 'Receive notifications', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['category' => 'pov', 'resource' => 'notification', 'action' => 'send', 'description' => 'Send notifications', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
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
                'configs' => ['enabled' => true],
                'metas' => ['visibility' => true]
            ],
            [
                'name' => 'manager',
                'description' => 'Manager with access to oversee processes and teams.',
                'permissions' => Permission::where('action', 'manage')->pluck('id')->toArray(),
                'configs' => ['enabled' => true],
                'metas' => ['visibility' => true]
            ],
            [
                'name' => 'user',
                'description' => 'Standard user with limited permissions.',
                'permissions' => Permission::whereIn('action', ['create', 'edit', 'view', 'send'])->pluck('id')->toArray(),
                'configs' => ['enabled' => true],
                'metas' => ['visibility' => true]
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

        // FEATURES
        $features = [
            ['country' => '*', 'name' => 'User Management', 'code' => 'user_management', 'type' => FeatureTypeEnum::MENU->value, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
            ['country' => '*', 'name' => 'POV Management', 'code' => 'pov_management', 'type' => FeatureTypeEnum::MENU->value, 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
        ];

        foreach ($features as $feature) {
            $features = Feature::updateOrCreate(
                ['country' => '*', 'code' => $feature['code'], 'type' => $feature['type']],
                $feature
            );
        }

        // MODULE
        $modules = [
            ['country' => '*', 'name' => 'User', 'code' => 'user', 'configs' => ['enabled' => true], 'metas' => ['visibility' => true]],
        ];

        foreach ($modules as $module) {
            $module = Module::updateOrCreate(
                ['country' => '*', 'code' => $module['code']],
                $module
            );
        }
    }
}
