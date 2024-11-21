<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'date',
        'is_balanced',
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class)->withPivot('team'); // Связь "многие ко многим"
    }
}
