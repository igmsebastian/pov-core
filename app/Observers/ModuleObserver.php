<?php

namespace App\Observers;

use App\Models\Module;
use Illuminate\Support\Str;

class ModuleObserver
{
    /**
     * Handle the Permission "creating" event.
     */
    public function creating(Module $module): void
    {
        $configs = $module->configs ?? [];
        $metas = $module->metas ?? [];

        // Configs
        if (!array_key_exists('enabled', $configs)) {
            $configs['enabled'] = true;
        }

        if (!array_key_exists('allowed_permissions', $configs)) {
            $configs['allowed_permissions'] = [];
        }

        // Metas
        if (!array_key_exists('visibility', $metas)) {
            $metas['visibility'] = true;
        }

        $module->configs = $configs;
        $module->metas = $metas;

        if (empty($role->code)) {
            $module->code = Str::slug($module->name, '_');
        }
    }
}
