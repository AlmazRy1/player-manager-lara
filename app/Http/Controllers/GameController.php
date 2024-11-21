<?php

namespace App\Http\Controllers;

use App\Models\Game;
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

    // Сохранение новой игры
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teams' => 'required|array',
            'teams.*.players' => 'required|array|min:1',
        ]);

        $game = Game::create([
            'date' => $validated['date'],
        ]);

        foreach ($validated['teams'] as $team) {
            $teamModel = $game->teams()->create();
            $teamModel->players()->sync($team['players']);
        }

        return redirect()->route('games.index')->with('success', 'Игра успешно создана!');
    }

    // Форма редактирования игры
    public function edit(Game $game)
    {
        $players = Player::all(); // Получение всех игроков
        $game->load('teams.players'); // Загрузка команд и игроков игры
        return view('games.edit', compact('game', 'players')); // Возврат формы редактирования игры
    }

    // Обновление данных игры
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'teams' => 'required|array',
            'teams.*.players' => 'required|array|min:1',
        ]);

        $game->update([
            'date' => $validated['date'],
        ]);

        $game->teams()->delete(); // Удаляем старые команды
        foreach ($validated['teams'] as $team) {
            $teamModel = $game->teams()->create();
            $teamModel->players()->sync($team['players']);
        }

        return redirect()->route('games.index')->with('success', 'Игра успешно обновлена!');
    }

    // Удаление игры
    public function destroy(Game $game)
    {
        $game->delete(); // Мягкое удаление игры
        return redirect()->route('games.index')->with('success', 'Игра успешно удалена!');
    }
}
