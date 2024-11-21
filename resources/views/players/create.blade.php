@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Добавить игрока</h1>
    <form action="{{ route('players.store') }}" method="POST" class="shadow-lg p-4 rounded bg-white">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Имя:</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="Введите имя игрока">
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Рейтинг:</label>
            <input type="number" name="rating" id="rating" class="form-control" step="0.01" placeholder="Введите рейтинг игрока">
        </div>

        <div class="mb-3">
            <label for="coefficient" class="form-label">Коэффициент:</label>
            <input type="number" name="coefficient" id="coefficient" class="form-control" step="0.01" placeholder="Введите коэффициент игрока">
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('players.index') }}" class="btn btn-secondary">Назад</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
