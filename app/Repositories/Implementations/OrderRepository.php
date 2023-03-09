<?php

namespace App\Repositories\Implementations;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements \App\Repositories\OrderRepository
{

    public function all(array $filters): LengthAwarePaginator
    {
        return Order::select(
            [
                'games.id as game_id',
                'games.name as game_name',
                'games.price as game_price',
                'games.profile_id as game_added_by',
                'orders.address as address',
                'orders.profile_id as game_bought_by',
            ])
            ->join('games', 'games.id', 'orders.game_id')
            ->join('user_profiles', 'user_profiles.id', 'orders.profile_id')
            ->filterable($filters['filter'] ?? [])
            ->sortable($filters['sort'] ?? [])
            ->paginate(Order::RECORDS_PER_PAGE);
    }

    public function store(array $data): Order
    {
        return Order::create($data);
    }

    public function show(int $id): Order
    {
        return Order::find($id);
    }

    public function update(int $id, array $data): bool
    {
        return Order::where('id', $id)->update($data);
    }

    public function destroy(int $id): bool
    {
        return Order::where('id', $id)->delete();
    }
}
