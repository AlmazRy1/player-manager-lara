<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'rating',
        'coefficient',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'player_team');
    }

    public function recalculateRating()
    {
        // Получаем все команды игрока
        $teams = $this->teams()
            ->whereHas('game', function ($query) {
                $query->whereNull('deleted_at'); // Условие для исключения мягко удаленных игр
            })
            ->with('game')->get();

        // Считаем сумму всех очков команд и количество игр
        $totalScore = 0;
        $gameCount = 0;
        
        foreach ($teams as $team) {
            $totalScore += $team->score;
            $gameCount++;
        }

        // Считаем новый рейтинг
        if ($gameCount > 0) {
            $oldTotalScore = $this->rating_imported / $this->coefficient_imported * $this->games_count_imported;
            $averageScore = ($totalScore + $oldTotalScore) / ($gameCount + $this->games_count_imported);
            $this->rating = $averageScore * $this->coefficient;
            $this->games_count = $gameCount;
            $this->save();
        }
        
    }
}
