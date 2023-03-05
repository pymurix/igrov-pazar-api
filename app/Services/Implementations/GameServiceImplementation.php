<?php

namespace App\Services\Implementations;

use App\Models\Game;
use App\Services\GameService;

class GameServiceImplementation implements GameService
{
    public function isGameBelongsToUser(Game $game, int $profileId): bool
    {
        return $game->profile_id === $profileId;
    }
}
