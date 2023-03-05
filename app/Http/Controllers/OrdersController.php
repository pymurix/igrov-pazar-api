<?php

namespace App\Http\Controllers;

use App\Http\Data\StoreOrderData;
use App\Http\Data\UpdateOrderData;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::join('games', 'orders.game_id', 'games.id')
            ->join('user_profiles', 'orders.profile_id', 'user_profiles.id')
            ->paginate(5);


        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderData $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderData $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
