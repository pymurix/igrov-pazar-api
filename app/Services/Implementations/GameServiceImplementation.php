<?php

namespace App\Services\Implementations;

use App\Models\Game;
use App\Services\GameService;

class GameServiceImplementation implements GameService
{
    public function isGameBelongsToUser(Game $game, int $userId): bool
    {
        return $game->user_id === $userId;
    }
}
