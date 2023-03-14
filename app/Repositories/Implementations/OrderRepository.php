<?php

namespace App\Repositories\Implementations;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository extends Repository implements \App\Repositories\OrderRepository
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function allWithFiltersAndPagination(array $filters): LengthAwarePaginator
    {
        return Order::select(
            [
                'orders.id as id',
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
}
