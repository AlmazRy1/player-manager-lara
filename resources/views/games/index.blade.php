@extends('layouts.app')

@section('content')
<h1>Список игр</h1>
<a href="{{ route('games.create') }}">Создать игру</a>
<table>
    <thead>
        <tr>
            <th>Название</th>
            <th>Дата</th>
            <th>Сбалансирована?</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($games as $game)
        <tr>
            <td>{{ $game->name }}</td>
            <td>{{ $game->date }}</td>
            <td>{{ $game->is_balanced ? 'Да' : 'Нет' }}</td>
            <td>
                <a href="{{ route('games.edit', $game->id) }}">Изменить</a>
                <form action="{{ route('games.destroy', $game->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
