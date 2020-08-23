<?php
namespace App\Repositories\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Support\Collection;

trait FormatPaginationTrait
{
    /**
     * @param $paginatedData
     * @return Collection
     */
    private static function formatPagination(paginate $paginatedData): Collection
    {
        return $paginatedData->map(function ($item) {
            return $item->format();
        });
    }
}
