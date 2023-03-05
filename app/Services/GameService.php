<?php

namespace App\Services;

use App\Models\Game;

interface GameService
{
    public function isGameBelongsToUser(Game $game, int $profileId): bool;
}
