@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Редактировать игрока</h1>
    <form action="{{ route('players.update', $player->id) }}" method="POST">
        @csrf
        @method('PUT')  <!-- Мы используем PUT для обновления записи -->
        <div class="mb-3">
            <label for="name" class="form-label">Имя:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $player->name) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="rating" class="form-label">Рейтинг:</label>
            <input type="number" step="0.01" name="rating" class="form-control" value="{{ old('rating', $player->rating) }}">
        </div>

        <div class="mb-3">
            <label for="coefficient" class="form-label">Коэфф.:</label>
            <input type="range" name="coefficient" class="form-range" min="0.01" max="1" step="0.01" value="{{ old('coefficient', $player->coefficient) }}" id="coefficient-slider">
            <div class="d-flex justify-content-between">
                <span>0.01</span>
                <span>1.00</span>
            </div>
            <input type="text" name="coefficient_display" class="form-control mt-2" id="coefficient-display" value="{{ old('coefficient', $player->coefficient) }}" readonly>
        </div>
        
        <div class="d-none d-md-flex text-center d-flex justify-content-between">
            <a href="{{ route('players.index') }}" class="btn btn-secondary w-auto mx-2">Отмена</a>
            <button type="submit" class="btn btn-success w-auto mx-2">Сохранить изменения</button>
        </div>
        <div class="d-md-none fixed-bottom bg-white border-top py-2">
            <div class="container text-center d-flex justify-content-between">
                <a href="{{ route('players.index') }}" class="btn btn-secondary w-auto">Отмена</a>
                <button type="submit" class="btn btn-success w-auto">Сохранить изменения</button>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const coefficientSlider = document.getElementById('coefficient-slider');
        const coefficientDisplay = document.getElementById('coefficient-display');

        coefficientSlider.addEventListener('input', function() {
            let value = parseFloat(this.value).toFixed(2);
            coefficientDisplay.value = value;
        });

        coefficientDisplay.value = parseFloat(coefficientSlider.value).toFixed(2);
    });
</script>
@endpush
@endsection
