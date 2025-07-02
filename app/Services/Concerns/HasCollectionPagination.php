<?php

namespace App\Services\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasCollectionPagination
{
    public function paginate($items, $perPage = 100, $page = null, $options = [])
	{
        $perPage = request()->query('per_page') ?: $perPage;

        if ($perPage == -1) {
            return $items;
        }

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        if (!isset($options['path'])) {
            $options['path'] = request()->url();
        }

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}
}
