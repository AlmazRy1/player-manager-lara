@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Добавить игрока</h1>
    <form action="{{ route('players.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Имя:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="rating" class="form-label">Рейтинг:</label>
            <input type="number" min="0.0" step="0.10" name="rating" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="coefficient" class="form-label">Коэфф.:</label>
            <input type="range" name="coefficient" class="form-range" min="0.1" max="1" step="0.1" value="0.1" id="coefficient-slider">
            <div class="d-flex justify-content-between">
                <span>0.1</span>
                <span>1.00</span>
            </div>
            <input type="text" name="coefficient_display" class="form-control mt-2" id="coefficient-display" required>
        </div>
        <div class="d-none d-md-flex text-center d-flex justify-content-between">
            <a href="{{ route('players.index') }}" class="btn btn-secondary w-auto mx-2">Назад</a>
            <button type="submit" class="btn btn-success w-auto mx-2">Сохранить</button>
        </div>
        <div class="d-md-none fixed-bottom bg-white border-top py-2">
            <div class="container text-center d-flex justify-content-between">
                <a href="{{ route('players.index') }}" class="btn btn-secondary w-auto">Назад</a>
                <button type="submit" class="btn btn-success w-auto">Сохранить</button>
            </div>
        </div>
    </form>
</div>


@push('scripts')
<script>
    // Инициализация ползунка для Коэфф.а
    const coefficientSlider = document.getElementById('coefficient-slider');
    const coefficientDisplay = document.getElementById('coefficient-display');

    // Функция для обновления значения
    coefficientSlider.oninput = function() {
        let value = parseFloat(this.value).toFixed(2); // Округление до 2 знаков
        coefficientDisplay.value = value; // Обновление поля с Коэфф.ом
    }

    // Установим начальное значение
    coefficientDisplay.value = parseFloat(coefficientSlider.value).toFixed(2);
</script>
@endpush
@endsection
