<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ModuleFilter extends QueryFilter
{
    /**
     * Search keyword.
     */
    public function keyword(?string $value): Builder
    {
        if (! $value) {
            return $this->builder;
        }

        return $this->builder->where(function (Builder $q) use ($value) {
            $q->where('name', 'like', "%{$value}%")
                ->orWhere('code',  'like', "%{$value}%");
        });
    }

    /**
     * Filter by name (exact or partial).
     */
    public function name(?string $value): Builder
    {
        if (! $value) {
            return $this->builder;
        }

        return $this->builder->where('name', 'like', "%{$value}%");
    }

    /**
     * Filter by code (exact or partial).
     */
    public function code(?string $value): Builder
    {
        if (! $value) {
            return $this->builder;
        }

        return $this->builder->where('code', 'like', "%{$value}%");
    }

    /**
     * Filter by status (exact or partial).
     */
    public function status(?string $value): Builder
    {
        if (! $value) {
            return $this->builder;
        }

        return $this->builder->where('status', 'like', "%{$value}%");
    }
}
