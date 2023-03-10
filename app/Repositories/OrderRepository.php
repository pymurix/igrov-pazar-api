<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepository extends Repository
{
    public function allWithFiltersAndPagination(array $filters): LengthAwarePaginator;
}
