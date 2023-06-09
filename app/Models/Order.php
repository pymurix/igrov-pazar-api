<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile_id',
        'user_id',
        'address',
        'game_id',
    ];

    const RECORDS_PER_PAGE = 5;

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
