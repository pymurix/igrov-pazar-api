<?php

namespace App\Http\Data;

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
