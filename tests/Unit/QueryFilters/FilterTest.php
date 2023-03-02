<?php

namespace Tests\Unit\QueryFilters;

use App\QueryFilters\Filterable;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    public function test_filter_method_returns_filtered_query_builder()
    {
        $queryBuilder = new Builder(new Connection(['driver' => 'sqlite']));

        $expectedQueryBuilder = clone $queryBuilder;
        $expectedQueryBuilder->where('name', '=', 'John');
        $expectedQueryBuilder->where('age', '>', 25);

        $filters = [
            'name' => [
                '=' => 'John'
            ],
            'age' => [
                '>' => 25
            ]
        ];

        $filteredQueryBuilder = Filterable::filter($queryBuilder, $filters);

        $this->assertEquals($expectedQueryBuilder->toSql(), $filteredQueryBuilder->toSql());
        $this->assertEquals($expectedQueryBuilder->getBindings(), $filteredQueryBuilder->getBindings());
    }

    public function test_filter_method_returns_original_query_builder_when_filters_array_is_empty()
    {
        $queryBuilder = new Builder(new Connection(['driver' => 'sqlite']));
        $expectedQueryBuilder = clone $queryBuilder;

        $filteredQueryBuilder = Filterable::filter($queryBuilder, []);

        $this->assertEquals($expectedQueryBuilder->toSql(), $filteredQueryBuilder->toSql());
        $this->assertEquals($expectedQueryBuilder->getBindings(), $filteredQueryBuilder->getBindings());
    }

    public function test_filter_method_returns_filtered_query_builder_with_one_filter()
    {
        $queryBuilder = new Builder(new Connection(['driver' => 'sqlite']));

        $expectedQueryBuilder = clone $queryBuilder;
        $expectedQueryBuilder->where('name', 'Murphy');

        $filters = [
            'name' => 'Murphy'
        ];

        $filteredQueryBuilder = Filterable::filter($queryBuilder, $filters);

        $this->assertEquals($expectedQueryBuilder->toSql(), $filteredQueryBuilder->toSql());
        $this->assertEquals($expectedQueryBuilder->getBindings(), $filteredQueryBuilder->getBindings());
    }
}
