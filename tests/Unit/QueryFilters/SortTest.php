<?php

namespace Tests\Unit\QueryFilters;

use App\QueryFilters\Sort;
use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Connection;

class SortTest extends TestCase
{
    public function test_sort_method_sorts_query_builder_correctly()
    {
        $query = new Builder(new Connection(['driver' => 'sqlite']));
        $query->from('games')
            ->select('id', 'title', 'created_at')
            ->where('status', '=', 'published')
            ->whereIn('category', ['action', 'adventure']);

        $expectedQuery = clone $query;
        $expectedQuery->orderBy('title', 'asc');

        $resultQuery = Sort::sort($query, ['title' => 'asc']);

        $this->assertEquals($expectedQuery->toSql(), $resultQuery->toSql());
        $this->assertEquals($expectedQuery->getBindings(), $resultQuery->getBindings());

    }

    public function test_sort_method_does_not_modify_query_if_sorts_is_empty()
    {
        $query = new Builder(new Connection(['driver' => 'sqlite']));
        $query->from('games')
            ->select('id', 'title', 'created_at')
            ->where('status', '=', 'published')
            ->whereIn('category', ['action', 'adventure']);
        $expectedQuery = clone $query;

        $resultQuery = Sort::sort($query, []);

        $this->assertEquals($expectedQuery->getBindings(), $resultQuery->getBindings());
        $this->assertEquals($expectedQuery->toSql(), $resultQuery->toSql());
    }
}
