<?php

namespace App\Http\Controllers;

use App\Events\OrderAdded;
use App\Http\Data\StoreOrderData;
use App\Http\Data\UpdateOrderData;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::select(
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
            ->filterable(request('filter', []))
            ->sortable(request('sort', []))
            ->paginate(Order::RECORDS_PER_PAGE);


        return response()->json($orders);
    }

    public function store(StoreOrderData $data)
    {
        $order = Order::create(
            [
                ...$data->toArray(),
                'profile_id' => Auth::user()->profile_id
            ]
        );
        Event::dispatch(new OrderAdded($order));
        return response()->json($order, Response::HTTP_CREATED);
    }

    public function show(Order $order)
    {
        $this->authorize('orderBelongsToUser', $order);
        return response()->json($order);
    }

    public function update(UpdateOrderData $request, int $id)
    {
        Order::where('id', $id)->update($request->toArray());
        return response()->json(null, Response::HTTP_ACCEPTED);
    }

    public function destroy(int $id)
    {
        Order::where('id', $id)
            ->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
