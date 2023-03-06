<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
