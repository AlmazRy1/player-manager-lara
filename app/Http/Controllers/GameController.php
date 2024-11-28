<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Список всех игр
    public function index()
    {
        // $games = Game::with('teams.players')->orderByDesc('date')->get(); // Загрузка всех игр с командами и игроками
        $games = Game::with([
            'teams.players' => function ($query) {
                $query->orderBy('rating', 'desc'); // Сортировка игроков по убыванию рейтинга
            }
        ])->orderByDesc('date')->get();
        return view('games.index', compact('games')); // Возврат на страницу списка игр
    }

    // Форма создания новой игры
    public function create()
    {
        $players = Player::all(); // Получение всех игроков
        return view('games.create', compact('players')); // Возврат формы создания игры
    }

    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'date' => 'required|date',
            'team_count' => 'required|integer|min:2',
            'players_per_team' => 'required|integer|min:1',
            'is_balanced' => 'required|boolean',
            'players' => 'required|array|min:2', // Должно быть выбрано минимум 2 игрока
            'players.*' => 'exists:players,id', // Проверяем, что ID существуют в таблице players
        ]);
        
        $isBalanced = $validated['is_balanced'];
        $teamsCount = $validated['players_per_team'];
        $players = Player::whereIn('id', $validated['players'])->get();

        // Создаем пустой массив для команд
        $teams = collect(range(1, $teamsCount))->map(fn ($i) => collect());
        if ($isBalanced) {
            // Сбалансированное распределение
            // Сортируем игроков по рейтингу (от самого сильного к самому слабому)
            $players = $players->sortByDesc('rating');

            // Инициализируем массив для суммарных рейтингов команд
            $teamsRatings = array_fill(0, $teamsCount, 0); // Заполняем массив нулями, по количеству команд

            foreach ($players as $player) {
                // Находим команду с минимальным суммарным рейтингом
                $minTeamIndex = array_search(min($teamsRatings), $teamsRatings); // Находим индекс команды с минимальным рейтингом
                
                // Добавляем игрока в эту команду
                $teams[$minTeamIndex]->push($player);
                
                // Обновляем суммарный рейтинг этой команды
                $teamsRatings[$minTeamIndex] += $player->rating;
            }
        } else {
            // Случайное распределение
            $players = $players->shuffle(); // Перемешиваем игроков случайным образом
    
            foreach ($players as $index => $player) {
                // Добавляем игрока в команду с индексом (по кругу)
                $teams[$index % $teamsCount]->push($player);
            }
        }

        // Создание игры
        $game = Game::create([
            'date' => $validated['date'],
            'is_balanced' => $validated['is_balanced'],
            'name' => 'Игра ' . $validated['date'],
        ]);

        // Создание команд
        foreach ($teams as $playersInTeam) {
            $team = $game->teams()->create(); // game_id заполняется автоматически
            // $team->players()->sync($playersInTeam->pluck('id')); // Привязываем игроков к команде
            $team->players()->saveMany($playersInTeam); // Привязываем игроков к команде
        }

        // Перенаправление после успешного сохранения
        return redirect()->route('games.index')->with('success', 'Игра успешно создана.');
    }

    // Форма редактирования игры
    public function edit(Game $game)
    {
        $game->load('teams.players'); // Загрузка команд и игроков игры
        $players = Player::all(); // Все игроки

        return view('games.edit', compact('game', 'players'));
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        // Обновляем дату игры
        $game->update([
            'date' => $request->input('date'),
        ]);

        // Обновляем очки каждой команды
        foreach ($request->input('teams', []) as $teamId => $teamData) {
            $team = Team::find($teamId);

            if ($team) {
                // Обновляем очки команды
                $team->update([
                    'score' => $teamData['score'],
                ]);

                // Обновляем рейтинг всех игроков команды
                foreach ($team->players as $player) {
                    $player->recalculateRating();
                }
            }
        }

        return redirect()->route('games.index')->with('success', 'Игра успешно обновлена.');
    }

    // Удаление игры
    public function destroy(Game $game)
    {
        $game->delete(); // Мягкое удаление игры
        return redirect()->route('games.index')->with('success', 'Игра успешно удалена!');
    }
}
