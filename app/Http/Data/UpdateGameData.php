<?php

namespace App\Http\Data;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class UpdateGameData extends Data
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
            'price' => ['required', 'numeric', 'between:0,999999.99'],
            'platform' => ['required', 'in:' . implode(',', array_values(Game::PLATFORMS))],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }
}
