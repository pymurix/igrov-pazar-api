<?php

namespace App\Http\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class StoreOrderData extends Data
{
    public function __construct(
        public int $gameId,
        public string $address
    )
    {}

    public static function rules(): array
    {
        return [
            'game_id' => ['required', 'integer'],
            'address' => ['required', 'string'],
        ];
    }
}
