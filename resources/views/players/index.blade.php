@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Список игроков</h1>
    <div class="mb-3">
        <a href="{{ route('players.create') }}" class="btn btn-success">Добавить игрока</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Имя</th>
                <th>Рейтинг</th>
                <th>Коэфф.</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($players as $player)
            <tr>
                <td>{{ $player->name }}</td>
                <td>{{ $player->rating }}</td>
                <td>{{ $player->coefficient }}</td>
                <td>
                    <a href="{{ route('players.edit', $player->id) }}" class="btn btn-primary btn-sm">Изменить</a>
                    <form action="{{ route('players.destroy', $player->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этого игрока?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
