<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;

Route::get('/', function () {
    return view('home');
});


Route::prefix('players')->name('players.')->group(function () {
    Route::get('/', [PlayerController::class, 'index'])->name('index'); // Список игроков
    Route::get('/create', [PlayerController::class, 'create'])->name('create'); // Форма добавления игрока
    Route::post('/', [PlayerController::class, 'store'])->name('store'); // Сохранение нового игрока
    Route::get('/{player}/edit', [PlayerController::class, 'edit'])->name('edit'); // Форма редактирования игрока
    Route::put('/{player}', [PlayerController::class, 'update'])->name('update'); // Обновление игрока
    Route::delete('/{player}', [PlayerController::class, 'destroy'])->name('destroy'); // Удаление игрока
});

Route::prefix('games')->name('games.')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('index'); // Список игр
    Route::get('/create', [GameController::class, 'create'])->name('create'); // Форма добавления игры
    Route::post('/', [GameController::class, 'store'])->name('store'); // Сохранение новой игры
    Route::get('/{game}/edit', [GameController::class, 'edit'])->name('edit'); // Форма редактирования игры
    Route::put('/{game}', [GameController::class, 'update'])->name('update'); // Обновление игры
    Route::delete('/{game}', [GameController::class, 'destroy'])->name('destroy'); // Удаление игры
});
