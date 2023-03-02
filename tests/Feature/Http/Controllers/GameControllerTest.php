<?php

namespace Http\Controllers;

use App\Models\Company;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    public function test_it_can_list_games()
    {
        $games = Game::factory()->count(10)->create();

        $response = $this->get('/api/games');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJson([
                'data' => $games->take(5)->toArray(),
            ]);
    }

    public function test_it_can_create_a_game()
    {
        $data = Game::factory()->make(
            [
                'user_id' => $this->user->id,
            ]
        );

        $response = $this->actingAs($this->user)
            ->postJson('/api/games', $data->toArray());

        $response
            ->assertStatus(201)
            ->assertJsonFragment($data->toArray());
        $this->assertDatabaseHas('games',
            $data->toArray()
        );
    }

    public function test_it_can_show_a_game()
    {
        $game = Game::factory()->create();

        $response = $this->getJson('/api/games/' . $game->id);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($game->toArray());
    }

    public function test_it_can_update_a_game()
    {
        $game = Game::factory()
            ->create(['user_id' => $this->user->id]);
        $gameUpdate = Game::factory()
            ->make([
                'company_id' => $game->company_id,
                'user_id' => $this->user->id,
            ])->toArray();

        $response = $this->actingAs($this->user)
            ->putJson('/api/games/' . $game->id, $gameUpdate);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($gameUpdate);
        $this->assertDatabaseHas('games',
            $gameUpdate + ['user_id' => $this->user->id]
        );
    }

    public function test_it_can_delete_a_game()
    {
        $game = Game::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->deleteJson('/api/games/' . $game->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('games', [
            'id' => $game->id,
        ]);
    }

    public function test_it_cant_delete_game_that_dont_belong_to_user()
    {
        $game = Game::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson('/api/games/' . $game->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('games', [
            'id' => $game->id,
        ]);
    }
}
