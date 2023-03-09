<?php

namespace App\Repositories\CacheDecorators;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class OrderRepositoryCacheDecorator implements OrderRepository
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    public function all(array $filters): LengthAwarePaginator
    {
        return Cache::remember('orders.all.'. json_encode($filters), 3600, function () use ($filters) {
            return $this->orderRepository->all($filters);
        });
    }

    public function store(array $data): Order
    {
        $order = $this->orderRepository->store($data);
        Cache::delete('orders.all.*');
        return $order;
    }

    public function show(int $id): Order
    {
        return Cache::remember("order.{$id}", 3600, function () use ($id) {
            return $this->orderRepository->show($id);
        });
    }

    public function update(int $id, array $data): bool
    {
        $updated = $this->orderRepository->update($id, $data);
        Cache::delete("order.{$id}");
        return $updated;
    }

    public function destroy(int $id): bool
    {
        $deleted = $this->orderRepository->destroy($id);
        Cache::delete("order.{$id}");
        return $deleted;
    }
}
