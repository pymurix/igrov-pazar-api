<?php

namespace App\Http\Requests;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    public function rules(): array
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
