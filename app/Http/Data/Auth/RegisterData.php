<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;

class RegisterRequest extends Data
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password,
        public ?\Illuminate\Http\UploadedFile $profileImage
    )
    {

    }

    public static function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'profileImage' => ['nullable', File::image()
                ->min(1024)
                ->max(12 * 1024)]
        ];
    }
}
