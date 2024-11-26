@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1>Список игр</h1>
        <a href="{{ route('games.create') }}" class="btn btn-primary">Создать игру</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Команды</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                <tr>
                    <td>{{ $game->date }}</td>
                    <td>
                        @foreach ($game->teams as $team)
                            <strong>Команда {{ $loop->iteration }}</strong> (Очки: {{ $team->score }}):
                            @foreach ($team->players as $player)
                                {{ $player->name }},
                            @endforeach
                            <br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('games.edit', $game->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('games.destroy', $game->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
