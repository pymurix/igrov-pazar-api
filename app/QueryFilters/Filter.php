<?php

namespace App\QueryFilters;

use Illuminate\Database\Query\Builder as QueryBuilder;

class Filter
{
    public static function filter(QueryBuilder $query, array $filters = []): QueryBuilder
    {
        foreach ($filters as $column => $filter) {
            if (is_array($filter)) {
                foreach ($filter as $operator => $value) {
                    $query->where(
                        $column,
                        $operator,
                        $value,
                    );
                }
            } else {
                $query->where($column, $filter);
            }
        }

        return $query;
    }
}
