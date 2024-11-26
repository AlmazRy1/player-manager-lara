@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Создать игру</h1>
    </div>
    <div class="card-body">
        <form action="{{ route('games.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Дата:</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Количество команд:</label>
                <input type="number" class="form-control" name="team_count" min="2" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Игроков в команде:</label>
                <input type="number" class="form-control" name="players_per_team" min="1" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="is_balanced" value="1">
                <label class="form-check-label">Сбалансировать команды?</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Выберите игроков:</label>
                <div class="row">
                    @foreach ($players as $player)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="players[]" value="{{ $player->id }}">
                                <label class="form-check-label">{{ $player->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
</div>
@endsection
