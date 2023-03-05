<?php

namespace App\Http\Data;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

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
