<?php

namespace App\Services;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class AbacService
{
    public function can(User $user, string $action, Model|string|null $resource = null): bool
    {
        $resourceType = is_object($resource)
            ? class_basename($resource)
            : (is_string($resource) ? $resource : null);

        if (!$resourceType) {
            return false;
        }

        $permission = Permission::where('action', $action)
            ->where('resource', $resourceType)
            ->first();

        if (!$permission) {
            return false;
        }

        $userPerm = $user->permissions()
            ->where('permission_id', $permission->id)
            ->first();

        if (!$userPerm) {
            return false;
        }

        $conditions = $userPerm->conditions ?? [];

        if (!empty($conditions['own_resource']) && $conditions['own_resource']) {
            if (!($resource instanceof Model) || $resource->user_id !== $user->id) {
                return false;
            }
        }

        return true;
    }
}
