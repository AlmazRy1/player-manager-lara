<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'score'
    ];

    // Одна команда принадлежит игре
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    // Одна команда имеет много игроков
    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_team');
    }

}
