<?php

namespace Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
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
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(Game::RECORDS_PER_PAGE, 'data')
            ->assertJson([
                'data' => $games->take(Game::RECORDS_PER_PAGE)->toArray(),
            ]);
    }

    public function test_it_can_create_a_game()
    {
        $data = Game::factory()->make(
            [
                'profile_id' => $this->user->profile()->first()->id,
            ]
        );

        $response = $this->actingAs($this->user)
            ->postJson('/api/games', $data->toArray());

        $response
            ->assertStatus(Response::HTTP_CREATED)
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
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($game->toArray());
    }

    public function test_it_can_update_a_game()
    {
        $game = Game::factory()
            ->create(['profile_id' => $this->user->profile()->first()->id]);
        $gameUpdate = Game::factory()
            ->make([
                'profile_id' => $this->user->profile()->first()->id,
            ])->toArray();

        $response = $this->actingAs($this->user)
            ->putJson('/api/games/' . $game->id, $gameUpdate);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($gameUpdate);
        $this->assertDatabaseHas('games',
            $gameUpdate + ['profile_id' => $this->user->profile()->first()->id]
        );
    }

    public function test_it_can_delete_a_game()
    {
        $game = Game::factory()
            ->create(
                [
                    'profile_id' =>
                    $this->user->profile()->first()->id
                ]
            );

        $response = $this->actingAs($this->user)
            ->deleteJson('/api/games/' . $game->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('games', [
            'id' => $game->id,
        ]);
    }

    public function test_it_cant_delete_game_that_dont_belong_to_user()
    {
        $game = Game::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson('/api/games/' . $game->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseHas('games', [
            'id' => $game->id,
        ]);
    }
}
