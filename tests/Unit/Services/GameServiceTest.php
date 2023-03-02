<?php

namespace Tests\Unit\Services;

use App\Models\Game;
use App\Services\Implementations\GameServiceImplementation;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    private $gameService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gameService = new GameServiceImplementation();
    }

    public function test_is_game_belongs_to_user_returns_true_if_game_belongs_to_user()
    {
        $game = new Game();
        $game->user_id = 1;
        $userId = 1;

        $result = $this->gameService->isGameBelongsToUser($game, $userId);

        $this->assertTrue($result);
    }

    public function test_is_game_belongs_to_user_returns_false_if_game_does_not_belong_to_user()
    {
        $game = new Game();
        $game->user_id = 2;
        $userId = 1;

        $result = $this->gameService->isGameBelongsToUser($game, $userId);

        $this->assertFalse($result);
    }
}
