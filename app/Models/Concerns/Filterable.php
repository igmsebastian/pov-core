<?php

namespace App\Models\Concerns;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilters(Builder $query, QueryFilter $filter): Builder
    {
        return $filter->apply($query);
    }
}
