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
            <div class="d-none d-md-flex text-center d-flex justify-content-between">
                <a href="{{ route('games.index') }}" class="btn btn-secondary w-auto mx-2">Отмена</a>
                <button type="submit" class="btn btn-success w-auto mx-2">Сохранить изменения</button>
            </div>
            <!-- Для мобильных -->
            <div class="d-md-none fixed-bottom bg-white border-top py-2">
                <div class="container text-center d-flex justify-content-between">
                    <a href="{{ route('games.index') }}" class="btn btn-secondary w-auto">Отмена</a>
                    <button type="submit" class="btn btn-success w-auto">Сохранить изменения</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
