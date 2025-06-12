<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Str;

class RoleObserver
{
    /**
     * Handle the Role "creating" event.
     */
    public function creating(Role $role): void
    {
        if (empty($role->configs)) {
            $role->configs = json_encode([
                'enabled' => true,
                'visibility' => true,
            ]);
        }

        // Set default values for metas if not provided
        if (empty($role->metas)) {
            $role->metas = json_encode([
                'style' => null,
                'icon' => null,
                'hexColor' => null,
                'custom' => [],
            ]);
        }

        if (empty($role->code)) {
            $role->code = Str::slug($role->name); // Ensures slug is set based on role name
        }
    }
}
