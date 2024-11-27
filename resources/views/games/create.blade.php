@extends('layouts.app')

@section('content')
<h1 style="text-align: center; margin-bottom: 20px;">Создать игру</h1>
<form action="{{ route('games.store') }}" method="POST" style="max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    @csrf
    <div style="margin-bottom: 15px;">
        <label for="date" style="display: block; font-weight: bold; margin-bottom: 5px;">Дата:</label>
        <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="team_count" style="display: block; font-weight: bold; margin-bottom: 5px;">Количество команд:</label>
        <input type="number" id="team_count" name="team_count" min="2" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="players_per_team" style="display: block; font-weight: bold; margin-bottom: 5px;">Игроков в команде:</label>
        <input type="number" id="players_per_team" name="players_per_team" min="1" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="is_balanced" style="display: block; font-weight: bold; margin-bottom: 5px;">Сбалансировать команды?</label>
        <input type="checkbox" id="is_balanced" name="is_balanced" value="1" style="transform: scale(1.5); margin-right: 10px;" checked>
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Выберите игроков:</label>
        @foreach ($players as $player)
            <div style="margin-bottom: 5px;">
                <input type="checkbox" id="player_{{ $player->id }}" name="players[]" value="{{ $player->id }}" style="transform: scale(1.2); margin-right: 10px;">
                <label for="player_{{ $player->id }}" style="font-size: 16px;">{{ $player->name }}</label>
            </div>
        @endforeach
    </div>
    <button type="submit" style="width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
        Создать
    </button>
</form>
@endsection
