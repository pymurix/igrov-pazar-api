<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface OrderRepository
{
    public function all(array $filters): LengthAwarePaginator;

    public function store(array $data): Order;

    public function show(int $id): Order;

    public function update(int $id, array $data): bool;

    public function destroy(int $id): bool;
}
