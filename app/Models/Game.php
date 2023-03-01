<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id',
        'platform',
        'company_id',
    ];

    const PLATFORMS = [
        'Playstation1' => 1,
        'Playstation2' => 2,
        'Playstation3' => 3,
        'Playstation4' => 4,
        'Playstation5' => 5,
        'Xbox360' => 6,
        'Nintendo Switch' => 7,
        'Nintendo DS' => 8,
        'Nintendo 3DS' => 9,
        'Nintendo GameFactory boy' => 10,
        'Nintendo Wii' => 11,
        'Nintendo Wii U' => 12,
        'Nintendo GameCube' => 13,
        'Playstation Portable' => 14,
        'Playstation Vita' => 15,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}