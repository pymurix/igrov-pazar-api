<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory()->create()->id,
            'game_id' => Game::factory()->create()->id,
            'address' => fake()->address(),
        ];
    }
}
