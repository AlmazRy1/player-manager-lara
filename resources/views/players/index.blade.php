@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Список игроков</h1>
    <a href="{{ route('players.create') }}" class="btn btn-success mb-3 w-100">Добавить игрока</a>
    <div class="table-responsive">
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
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('players.edit', $player->id) }}" class="btn btn-primary btn-sm w-100">Изменить</a>
                            <button class="btn btn-danger btn-sm w-100" onclick="confirmDelete({{ $player->id }})">Удалить</button>
                        </div>
                        <form id="delete-form-{{ $player->id }}" action="{{ route('players.destroy', $player->id) }}" method="POST" style="display: none;">
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
