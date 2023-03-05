<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address',
        'game_id',
    ];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}