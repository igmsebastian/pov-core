<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver
{
    /**
     * Handle the Permission "creating" event.
     */
    public function creating(Permission $permission): void
    {
        $configs = $permission->configs ?? [];
        $metas = $permission->metas ?? [];

        if (!array_key_exists('enabled', $configs)) {
            $configs['enabled'] = true;
        }

        if (!array_key_exists('visibility', $metas)) {
            $metas['visibility'] = true;
        }

        $permission->configs = $configs;
        $permission->metas = $metas;
    }
}
