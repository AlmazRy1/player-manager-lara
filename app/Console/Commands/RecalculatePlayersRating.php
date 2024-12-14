<?php

namespace App\Console\Commands;

use App\Models\Player;
use Illuminate\Console\Command;

class RecalculatePlayersRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'players:recalculate-rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate ratings for all players based on non-deleted games';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting rating recalculation for all players...');

        // Получаем всех игроков
        $players = Player::all();

        // Пересчитываем рейтинг для каждого игрока
        foreach ($players as $player) {
            $teams = $player->teams()
                ->whereHas('game', function ($query) {
                    $query->whereNull('deleted_at'); // Условие: только не удаленные игры
                })
                ->with('game') // Загружаем игры команд
                ->get();

            $totalScore = 0;
            $gameCount = 0;

            foreach ($teams as $team) {
                $totalScore += $team->score;
                $gameCount++;
            }

            // Считаем новый рейтинг
            if ($gameCount > 0) {
                $oldTotalScore = $player->rating_imported / $player->coefficient_imported * $player->games_count_imported;
                $averageScore = ($totalScore + $oldTotalScore) / ($gameCount + $player->games_count_imported);
                $player->rating = $averageScore * $player->coefficient;
                $player->games_count = $player->games_count_imported + $gameCount;
                $player->save();
                $this->info("Player {$player->name} rating recalculated.");
            }

            
        }

        $this->info('Rating recalculation completed successfully.');
    }
}
