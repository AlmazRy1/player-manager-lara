<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Имя игрока
            $table->decimal('rating', 5, 2)->default(0); // Рейтинг
            $table->decimal('rating_imported', 5, 2)->default(0); // Рейтинг
            $table->decimal('coefficient', 5, 2)->default(0); // Коэфф.
            $table->decimal('coefficient_imported', 5, 2)->default(0); // Коэфф.
            $table->integer('games_count', false, true)->default(0); // Количество игр.
            $table->integer('games_count_imported')->default(0); // Количество игр в прошлом.
            $table->softDeletes(); // Мягкое удаление
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
