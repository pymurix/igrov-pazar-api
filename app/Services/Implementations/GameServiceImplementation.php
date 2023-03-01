<?php

namespace App\Services\Implementations;

use App\Models\Game;
use App\Services\GameService;

class GameServiceImplementation implements GameService
{
    public function isGameBelongsToUser(Game $game, int $userId): bool
    {
        if ($game->user_id === $userId) {
            return true;
        }
        return false;
    }
}
