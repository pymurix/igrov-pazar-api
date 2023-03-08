<?php

namespace Tests\Integration\Listeners;

use App\Events\OrderAdded;
use App\Listeners\GameBoughtListener;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameBoughtTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_bought_Listener()
    {
        $order = Order::factory()->create();

        $event = new OrderAdded($order);
        $listener = new GameBoughtListener();
        $listener->handle($event);

        $this->assertDatabaseHas('games', [
            'id' => $order->game()->first()->id,
            'is_bought' => true,
        ]);
    }
}
