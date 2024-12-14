<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'date',
        'is_balanced',
    ];

    // Одна игра имеет много команд
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    // Хук на событие удаления игры
    protected static function booted()
    {
        static::deleted(function ($game) {
            // Получаем все команды в этой игре
            $teams = $game->teams()->with('players')->get();

            // Собираем всех уникальных игроков через команды
            $players = $teams->flatMap(function ($team) {
                return $team->players; // Получаем игроков для каждой команды
            })->unique('id'); // Убираем дублирующихся игроков по их ID

            // Пересчитываем рейтинг для каждого уникального игрока
            foreach ($players as $player) {
                $player->recalculateRating(); // Вызов метода пересчета рейтинга
            }
        });
    }

}
