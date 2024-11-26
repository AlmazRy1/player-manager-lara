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
        $games = Game::with('teams.players')->get(); // Загрузка всех игр с командами и игроками
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
        ]);

        // Создание игры
        $game = Game::create([
            'date' => $validated['date'],
            'is_balanced' => $validated['is_balanced'],
            'name' => 'Игра ' . $validated['date'],
        ]);

        // Разделение игроков по командам
        $players = collect($validated['players'])->shuffle();
        $playersPerTeam = $players->chunk($validated['players_per_team']);

        // Создание команд
        foreach ($playersPerTeam as $playersInTeam) {
            $team = $game->teams()->create(); // game_id заполняется автоматически
            $team->players()->sync($playersInTeam->toArray()); // Привязываем игроков к команде
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
                $team->update([
                    'score' => $teamData['score'], // Сохраняем новые очки
                ]);
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
