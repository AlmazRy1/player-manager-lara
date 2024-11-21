<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::all(); // Получаем всех игроков
        return view('players.index', compact('players')); // Отображаем их на странице
    }

    public function create()
    {
        return view('players.create'); // Форма для добавления игрока
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:100',
            'coefficient' => 'nullable|numeric|min:0|max:100',
        ]);

        Player::create($validated); // Создаем нового игрока
        return redirect()->route('players.index')->with('success', 'Игрок добавлен.');
    }

    public function edit(Player $player)
    {
        return view('players.edit', compact('player')); // Форма для редактирования игрока
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:100',
            'coefficient' => 'nullable|numeric|min:0|max:100',
        ]);

        $player->update($validated); // Обновляем игрока
        return redirect()->route('players.index')->with('success', 'Игрок обновлен.');
    }

    public function destroy(Player $player)
    {
        $player->delete(); // Мягкое удаление игрока
        return redirect()->route('players.index')->with('success', 'Игрок удален.');
    }
}
