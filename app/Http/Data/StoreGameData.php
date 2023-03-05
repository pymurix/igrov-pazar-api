<?php

namespace App\Http\Data;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;

class StoreGameData extends Data
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
        public int $platform,
        public int $companyId,
    )
    {}

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'between:0,9999.99'],
            'platform' => ['required', 'in:' . implode(',', array_values(Game::PLATFORMS))],
            'companyId' => ['required', 'integer'],
        ];
    }
}
