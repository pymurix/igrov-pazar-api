<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'profile_id',
        'platform',
        'company_id',
    ];

    const RECORDS_PER_PAGE = 5;
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

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
