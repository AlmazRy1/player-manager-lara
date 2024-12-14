@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Список игр</h1>
    <a href="{{ route('games.create') }}" class="btn btn-success mb-3 w-100 d-none d-md-block">Создать игру</a>

    <div class="games-list">
        @foreach ($games as $game)
        <div class="game bg-light rounded border mb-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fs-5 fw-bold mb-0">{{ $game->date }}</h3>
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#game-{{ $game->id }}" aria-expanded="false">
                    Подробнее
                </button>
            </div>
            <div class="collapse mt-3" id="game-{{ $game->id }}">
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    @foreach ($game->teams as $team)
                    <div class="col">
                        <div class="p-3 bg-light rounded border">
                            @php
                                $totalRating = $team->players->sum('rating');
                            @endphp
                            <strong>Команда-{{ $loop->iteration }} (<span style="color:#fd790d">{{ $team->score }}</span>)</strong>
                            <span style="font-size: 0.9rem; color:#0d6efd">
                                [ {{ $totalRating }} ]
                            </span>
                            <ul class="list-unstyled">
                                @foreach ($team->players as $player)
                                <li>{{ $player->name }}
                                    <span style="font-size: 0.9rem; color:#0d6efd">
                                    [ {{ $player->rating }} ]
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex flex-column gap-2 mt-3">
                    <a href="{{ route('games.edit', $game->id) }}" class="btn btn-primary btn-sm w-100 py-2">Изменить</a>
                    <button class="btn btn-danger btn-sm w-100 py-2" onclick="confirmDelete({{ $game->id }})">Удалить</button>
                </div>
                <form id="delete-form-{{ $game->id }}" action="{{ route('games.destroy', $game->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        @endforeach
        <div>&nbsp;</div>
    </div>
</div>

<div class="d-md-none fixed-bottom bg-white border-top py-2">
    <div class="container text-center">
        <a href="{{ route('games.create') }}" class="btn btn-success w-100">Создать игру</a>
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
