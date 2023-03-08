<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\OrderAdded;
use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->adminUser = $this->createUser([User::ROLE_ADMIN]);
    }

    public function test_can_index_orders()
    {
        $data = Order::factory()->count(8)->create();
        $assertData = $this->constructAssertData($data);

        $response = $this
            ->actingAs($this->adminUser)
            ->get('/api/orders');

        $response->assertOk()
            ->assertJsonCount(Order::RECORDS_PER_PAGE, 'data')
            ->assertJsonFragment(
                ['data' => $assertData->take(Order::RECORDS_PER_PAGE)->toArray()]
            );
    }

    public function test_can_add_order()
    {
        $order = Order::factory()->make(
            ['profile_id' => $this->user->profile()->first()->id]
        )->toArray();
        Event::fake();

        $response = $this
            ->actingAs($this->user)
            ->post('/api/orders', $order);

        $response->assertCreated()
            ->assertJsonFragment($order);
        $this->assertDatabaseHas(Order::class, $order);
        Event::assertDispatched(OrderAdded::class);
    }

    public function test_can_update_order()
    {
        $data = Order::factory()->create();
        $dataToUpdate = Order::factory()->create([
            'profile_id' => $data->profile_id,
            'game_id' => $data->game_id,
        ])->toArray();

        $response = $this
            ->actingAs($this->adminUser)
            ->put('/api/orders/' . $data->id, $dataToUpdate);

        $response->assertAccepted();
        $this->assertDatabaseHas(Order::class, $dataToUpdate);
    }

    public function test_it_can_show_order()
    {
        $data = Order::factory()->create(
            ['profile_id' => $this->user->profile()->first()->id]
        );

        $response = $this
            ->actingAs($this->user)
            ->get('/api/orders/' . $data->id);

        $response->assertOk()
            ->assertJsonFragment($data->toArray());
    }

    public function test_it_can_delete_order()
    {
        $data = Order::factory()->create();

        $response = $this
            ->actingAs($this->adminUser)
            ->delete('/api/orders/' . $data->id);

        $response->assertNoContent();
        $this->assertDatabaseMissing(Order::class, $data->toArray());
    }

    private function constructAssertData(Collection $data): Collection
    {
        $returnData = new Collection();
        /** @var Order $element */
        foreach ($data as $element)
        {
            $returnElement = [
                'game_id' => $element->game_id,
                'game_name' => $element->game()->first()->name,
                'game_price' => $element->game()->first()->price,
                'game_added_by' => $element->game()->first()->profile_id,
                'address' => $element->address,
                'game_bought_by' => $element->profile_id
            ];
            $returnData->push($returnElement);
        }

        return $returnData;
    }
}
