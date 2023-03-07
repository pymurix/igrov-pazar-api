<?php

namespace App\Http\Data\Auth;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class MobileLoginRequest extends Data
{
    public function __construct(
        public string $email,
        public string $password,
        public string $deviceName,
    )
    {}

    public static function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string'],
        ];
    }
}
