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
        $configs = $role->configs ?? [];
        $metas = $role->metas ?? [];

        if (!array_key_exists('enabled', $configs)) {
            $configs['enabled'] = true;
        }

        if (!array_key_exists('visibility', $metas)) {
            $metas['visibility'] = true;
        }

        $role->configs = $configs;
        $role->metas = $metas;

        if (empty($role->code)) {
            $role->code = Str::slug($role->name, '_');
        }
    }
}
