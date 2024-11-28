@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Создать игру</h1>
    <form action="{{ route('games.store') }}" method="POST" class="mx-auto bg-light p-4 rounded shadow-sm" style="max-width: 600px;">
        @csrf

        <!-- Поле выбора даты -->
        <div class="mb-3">
            <label for="date" class="form-label fw-bold">Дата:</label>
            <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" class="form-control" required>
        </div>

        <!-- Поле количества команд -->
        <div class="mb-3">
            <label for="team_count" class="form-label fw-bold">Количество команд:</label>
            <input type="number" id="team_count" name="team_count" min="2" class="form-control" required>
        </div>

        <!-- Поле игроков в команде -->
        <div class="mb-3">
            <label for="players_per_team" class="form-label fw-bold">Игроков в команде:</label>
            <input type="number" id="players_per_team" name="players_per_team" min="1" class="form-control" required>
        </div>

        <!-- Чекбокс "Сбалансировать команды" -->
        <div class="form-check form-switch mb-4">
            <input type="checkbox" id="is_balanced" name="is_balanced" value="1" class="form-check-input" checked>
            <label for="is_balanced" class="form-check-label fw-bold">Сбалансировать команды</label>
        </div>

        <!-- Список игроков -->
        <div class="mb-3">
            <label class="form-label fw-bold">Выберите игроков для разбивки:</label>
            <div class="row g-3">
                @foreach ($players as $player)
                <div class="col-12 col-md-6">
                    <div class="card" onclick="toggleCheckbox({{ $player->id }})" style="cursor: pointer;">
                        <div class="card-body d-flex align-items-center">
                            <div class="form-check form-switch me-3">
                                <input type="checkbox" id="player_{{ $player->id }}" name="players[]" value="{{ $player->id }}" class="form-check-input">
                            </div>
                            <label for="player_{{ $player->id }}" class="form-check-label fw-bold">{{ $player->name }}</label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="d-none d-md-flex text-center d-flex justify-content-between">
            <a href="{{ route('games.index') }}" class="btn btn-secondary w-auto mx-2">Назад</a>
            <button type="submit" class="btn btn-success w-auto mx-2">Создать</button>
        </div>
        <div class="d-md-none fixed-bottom bg-white border-top py-2">
            <div class="container text-center d-flex justify-content-between">
                <a href="{{ route('games.index') }}" class="btn btn-secondary w-auto">Назад</a>
                <button type="submit" class="btn btn-success w-auto">Создать</button>
            </div>
        </div>
    </form>
</div>
<script>
    function toggleCheckbox(playerId) {
        var checkbox = document.getElementById('player_' + playerId);
        checkbox.checked = !checkbox.checked; // переключаем состояние чекбокса
    }
</script>
@endsection
