@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Список игр</h1>
    <a href="{{ route('games.create') }}" class="btn btn-success mb-3 w-100">Создать игру</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
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
                            <strong>Команда {{ $loop->iteration }}</strong>:
                            @foreach ($team->players as $player)
                                {{ $player->name }} ({{ $player->rating }}),
                            @endforeach
                            <br>
                        @endforeach
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('games.edit', $game->id) }}" class="btn btn-primary btn-sm w-100">Изменить</a>
                            <button class="btn btn-danger btn-sm w-100" onclick="confirmDelete({{ $game->id }})">Удалить</button>
                        </div>
                        <form id="delete-form-{{ $game->id }}" action="{{ route('games.destroy', $game->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(gameId) {
        Swal.fire({
            title: 'Вы уверены?',
            text: "Удаление нельзя будет отменить!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Да, удалить',
            cancelButtonText: 'Отмена'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + gameId).submit();
            }
        });
    }
</script>
@endsection
