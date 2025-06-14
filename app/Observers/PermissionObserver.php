<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     */
    public function created(Permission $permission): void
    {
        if (empty($permission->configs)) {
            $permission->configs = json_encode([
                'enabled' => true,
            ]);
        }

        // Set default values for metas if not provided
        if (empty($permission->metas)) {
            $permission->metas = json_encode([
                'style' => null,
                'icon' => null,
                'hexColor' => null,
                'visibility' => true,
                'custom' => [],
            ]);
        }

        $permission->save();
    }
}
