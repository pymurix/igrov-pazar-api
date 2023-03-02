<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use App\Services\GameService;

class GamePolicy
{
    public function __construct(private readonly GameService $gameService)
    {
    }

    public function write(User $user, Game $game): bool
    {
        return $user->hasRole([User::ROLE_ADMIN]) ||
            $this->gameService
                ->isGameBelongsToUser($game, $user->id);
    }
}
