<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SearchAndSort
 *
 * @package App\Traits
 */
trait SearchAndSort
{
    /**
     * Apply sorting on query
     *
     * @param  Builder $query
     * @param  array   $sortData
     * @return Builder
     */
    public function scopeApplySort(
        Builder $query,
        array $sortData
    ): Builder {
        $sortOrder = 'desc';
        $sortColumn = $this->getKeyName();
        if (isset($sortData['orderBy'])
            && !empty($sortData['orderBy'])
            && in_array(strtolower($sortData['orderBy']), ['asc', 'desc'])
        ) {
            $sortOrder = $sortData['orderBy'];
        }

        if (!empty($sortData['orderByColumn'])
            && self::isSortableColumn($sortData['orderByColumn'])
        ) {
            $sortColumn =
                self::$columns[$sortData['orderByColumn']]['table_field'];
        }

        $orderByString = "$sortColumn $sortOrder";
        return $query->orderByRaw($orderByString);
    }

    /**
     * Apply filter on query
     *
     * @param  Builder $query
     * @param  array   $filterData
     * @return Builder
     */
    public function scopeApplyFilter(
        Builder $query,
        array $filterData
    ): Builder {
        if (empty($filterData['filter'])) {
            return $query;
        }
        foreach ($filterData['filter'] as $column => $value) {

            if (!self::isSearchableColumn($column)) {
                continue;
            }
            self::$columns[$column]['table_field'];
            $value = '%' . trim($value) . '%';

                $query->where(
                    self::$columns[$column]['table_field'],
                    'LIKE',
                    $value
                );

        }

        return $query;
    }

    /**
     * Check column is searchable
     *
     * @param  string $column
     * @return bool
     */
    public function isSearchableColumn(string $column): bool
    {
        return isset(self::$columns[$column]) &&
            self::$columns[$column]['searchable'] &&
            self::$columns[$column]['table_field'];
    }
    /**
     * Check column is sortable
     *
     * @param  string $column
     * @return bool
     */
    public function isSortableColumn(string $column): bool
    {
        return isset(self::$columns[$column]) &&
            self::$columns[$column]['sortable'] &&
            self::$columns[$column]['table_field'];
    }
}
