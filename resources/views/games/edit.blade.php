@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Редактировать игру</h1>
    </div>
    <div class="card-body">
        <form action="{{ route('games.update', $game->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Дата:</label>
                <input type="date" class="form-control" name="date" value="{{ $game->date }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Команды:</label>
                @foreach ($game->teams as $team)
                    <div class="mb-4 border p-3 rounded">
                        <strong>Команда {{ $loop->iteration }}</strong>
                        <ul>
                            @foreach ($team->players as $player)
                                <li>{{ $player->name }}</li>
                            @endforeach
                        </ul>
                        <div class="mb-3">
                            <label>Очки команды:</label>
                            <input type="number" class="form-control" name="teams[{{ $team->id }}][score]" 
                                   value="{{ $team->score }}" min="0" required>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
</div>
@endsection
