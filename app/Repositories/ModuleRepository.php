<?php

namespace App\Repositories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Collection;

class ModuleRepository
{
    public function fetchAll($filters): Collection
    {
        return Module::filters($filters)->get();
    }

    public function findModuleByCode(string $code): Module|null
    {
        return Module::firstWhere('code', $code);
    }

    public function create(array $data): Module
    {
        return Module::create($data);
    }

    public function update(Module $module, array $data): Module
    {
        return tap($module)->update($data);
    }

    public function delete(Module|array $module): bool|int
    {
        if (is_array($module)) {
            return Module::destroy($module);
        }

        return Module::delete($module);
    }
}
