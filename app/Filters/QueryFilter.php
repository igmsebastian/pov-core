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
    ) {}

    /**
     * Apply filtering of results.
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        $table = $builder->getModel()->getTable();

        foreach ($this->filters() as $key => $value) {
            if ($value === '') {
                continue;
            }

            // Priority: custom method > direct column match
            if (method_exists($this, $key)) {
                $this->{$key}($value);
            } elseif (Schema::hasColumn($table, $key)) {
                $this->applyColumnFilter($key, $value);
            }
        }

        return $this->builder;
    }

    /**
     * Dynamically apply column filter logic.
     */
    protected function applyColumnFilter(string $column, mixed $value): void
    {
        if (is_array($value)) {
            $this->applyAdvancedFilter($column, $value);
        } elseif ($value === 'null') {
            $this->builder->whereNull($column);
        } elseif ($value === 'not_null') {
            $this->builder->whereNotNull($column);
        } else {
            $this->builder->where($column, $value);
        }
    }

    /**
     * Support for range and in-clause filtering.
     */
    protected function applyAdvancedFilter(string $column, array $value): void
    {
        if (isset($value['from'], $value['to'])) {
            $this->builder->whereBetween($column, [$value['from'], $value['to']]);
        } elseif (isset($value['in']) && is_array($value['in'])) {
            $this->builder->whereIn($column, $value['in']);
        }
    }

    /**
     * Extract all query filters from the request.
     */
    public function filters(): array
    {
        return $this->request->all();
    }

    /**
     * Apply sorting of results.
     */
    public function sort(array $value = []): Builder
    {
        $column = $value['by'] ?? null;
        $order = $value['order'] ?? 'desc';

        if ($column && Schema::hasColumn($this->builder->getModel()->getTable(), $column)) {
            return $this->builder->orderBy($column, $order);
        }

        return $this->builder;
    }

    /**
     * Apply limit of results.
     */
    public function limit(int $value = 10): Builder
    {
        return $this->builder->limit($value);
    }
}
