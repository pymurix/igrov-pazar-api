<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function orderBelongsToUser(User $user, Order $order): bool
    {
        return $user->profile_id === $order->profile_id;
    }
}
