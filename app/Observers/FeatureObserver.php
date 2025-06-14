<?php

namespace App\Observers;

use App\Models\Feature;
use Illuminate\Support\Str;

class FeatureObserver
{
    /**
     * Handle the Permission "creating" event.
     */
    public function creating(Feature $feature): void
    {
        $configs = $feature->configs ?? [];
        $metas = $feature->metas ?? [];

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

        $feature->configs = $configs;
        $feature->metas = $metas;

        if (empty($role->code)) {
            $feature->code = Str::slug($feature->name, '_');
        }
    }
}
