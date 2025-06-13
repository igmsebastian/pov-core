<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
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
            $q->where('email', 'like', "%{$value}%")
                ->orWhere('name',  'like', "%{$value}%")
                ->orWhere('samaccountname',  'like', "%{$value}%");
        });
    }

    /**
     * Filter by email (exact or partial).
     */
    public function email(?string $value): Builder
    {
        if (! $value) {
            return $this->builder;
        }

        return $this->builder->where('email', 'like', "%{$value}%");
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
     * Filter by samaccountname (exact or partial).
     */
    public function samaccountname(?string $value): Builder
    {
        if (! $value) {
            return $this->builder;
        }

        return $this->builder->where('samaccountname', 'like', "%{$value}%");
    }
}
