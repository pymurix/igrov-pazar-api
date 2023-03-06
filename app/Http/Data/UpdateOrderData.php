<?php

namespace App\Http\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class UpdateOrderData extends Data
{
    public function __construct(
        public ?int $gameId,
        public ?int $profileId,
        public ?string $address,
    )
    {}

    public static function rules(): array
    {
        return [
            'game_id' => ['nullable', 'numeric'],
            'profile_id' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
        ];
    }
}
