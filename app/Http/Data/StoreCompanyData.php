<?php

namespace App\Http\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class StoreCompanyData extends Data
{
    public function __construct(
        public string $name
    )
    {
    }

    public static function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
