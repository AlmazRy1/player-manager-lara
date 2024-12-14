<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('home'); // Представление для панели управления
})->middleware('auth')->name('home');

// Группа маршрутов с защитой auth
Route::middleware('auth')->group(function () {
    // Маршруты для игроков
    Route::prefix('players')->name('players.')->group(function () {
        Route::get('/', [PlayerController::class, 'index'])->name('index');
        Route::get('/create', [PlayerController::class, 'create'])->name('create');
        Route::post('/', [PlayerController::class, 'store'])->name('store');
        Route::get('/{player}/edit', [PlayerController::class, 'edit'])->name('edit');
        Route::put('/{player}', [PlayerController::class, 'update'])->name('update');
        Route::delete('/{player}', [PlayerController::class, 'destroy'])->name('destroy');
    });

    // Маршруты для игр
    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/', [GameController::class, 'index'])->name('index');
        Route::get('/create', [GameController::class, 'create'])->name('create');
        Route::post('/', [GameController::class, 'store'])->name('store');
        Route::get('/{game}/edit', [GameController::class, 'edit'])->name('edit');
        Route::put('/{game}', [GameController::class, 'update'])->name('update');
        Route::delete('/{game}', [GameController::class, 'destroy'])->name('destroy');
    });
});

// Маршруты для авторизации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
