<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id(); // ID игры
            $table->string('name'); // Название игры
            $table->date('date'); // Дата проведения игры
            $table->boolean('is_balanced')->default(true); // Сбалансирована ли разбивка
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at (для мягкого удаления)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
