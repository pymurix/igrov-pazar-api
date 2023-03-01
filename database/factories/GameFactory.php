<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name,
            'description' => fake()->sentence,
            'price' => fake()->randomFloat(2, 0, 400),
            'user_id' => User::factory()->create()->id,
            'platform' => fake()->randomElement(array_values(Game::PLATFORMS)),
            'company_id' => Company::factory()->create()->id,
        ];
    }
}