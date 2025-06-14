<?php

namespace App\Repositories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Collection;

class FeatureRepository
{
    public function fetchAll($filters): Collection
    {
        return Feature::filters($filters)->get();
    }

    public function findFeatureByCode(string $code): Feature|null
    {
        return Feature::firstWhere('code', $code);
    }

    public function findFeatureByType(string $type): Collection
    {
        return Feature::where('type', $type)->get();
    }

    public function create(array $data): Feature
    {
        return Feature::create($data);
    }

    public function update(Feature $feature, array $data): Feature
    {
        return tap($feature)->update($data);
    }

    public function delete(Feature|array $feature): bool|int
    {
        if (is_array($feature)) {
            return Feature::destroy($feature);
        }

        return Feature::delete($feature);
    }
}
