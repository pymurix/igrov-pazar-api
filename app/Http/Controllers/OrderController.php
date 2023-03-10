<?php

namespace App\Http\Controllers;

use App\Events\OrderAdded;
use App\Http\Data\StoreOrderData;
use App\Http\Data\UpdateOrderData;
use App\Repositories\OrderRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class OrderController extends Controller
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    public function index()
    {
        $orders = $this->orderRepository->allWithFiltersAndPagination(request()->all());
        return response()->json($orders);
    }

    public function store(StoreOrderData $data)
    {
        $order = $this->orderRepository->store([
            ...$data->toArray(),
            'profile_id' => Auth::user()->profile_id
        ]);
        Event::dispatch(new OrderAdded($order));
        return response()->json($order, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        $order = $this->orderRepository->show($id);
        $this->authorize('orderBelongsToUser', $order);
        return response()->json($order);
    }

    public function update(UpdateOrderData $request, int $id)
    {
        $updated = $this->orderRepository->update($id, $request->toArray());
        return response()->json(['updated' => $updated], Response::HTTP_ACCEPTED);
    }

    public function destroy(int $id)
    {
        $deleted = $this->orderRepository->destroy($id);
        return response()->json(['deleted' => $deleted], Response::HTTP_NO_CONTENT);
    }
}
