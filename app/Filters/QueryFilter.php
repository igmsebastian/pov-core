<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected Builder $builder;

    public function __construct(
        protected Request $request
    ) {
    }

    /**
     * Apply filtering of results.
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (empty($value)) {
                continue;
            }

            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return $this->request->all();
    }

    /**
     * Apply sorting of results.
     */
    public function sort(array $value = []): Builder
    {
        if (isset($value['by']) && !Schema::hasColumn($this->builder->getModel()->getTable(), $value['by'])) {
            return $this->builder;
        }

        return $this->builder->orderBy(
            $value['by'],
            $value['order'] ?? 'desc'
        );
    }

    /**
     * Apply limit of results.
     */
    public function limit(int $value = 10): Builder
    {
        return $this->builder->limit($value);
    }
}
