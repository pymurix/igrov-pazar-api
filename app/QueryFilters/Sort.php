<?php

namespace App\QueryFilters;

use Illuminate\Database\Query\Builder as QueryBuilder;

class Sort
{
    public static function sort(QueryBuilder $query, array $sorts = []): QueryBuilder
    {
        foreach ($sorts as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }
}
