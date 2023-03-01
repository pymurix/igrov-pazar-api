<?php

namespace App\QueryFilters;

use Illuminate\Database\Query\Builder as QueryBuilder;
class Filterable
{
    public static function filter(QueryBuilder $query, array $filters = [], $freeLike = false): QueryBuilder
    {
        foreach ($filters as $column => $filter) {
            foreach ($filter as $operator => $value) {
                $query->where(
                    $column,
                    $operator,
                    $freeLike ? $value : '%' . $value . '%'
                );
            }
        }

        return $query;
    }
}
