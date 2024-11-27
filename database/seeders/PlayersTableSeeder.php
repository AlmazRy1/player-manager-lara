<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Путь к JSON-файлу
        $jsonFilePath = database_path('data/players.json');

        // Чтение данных из файла
        $jsonData = file_get_contents($jsonFilePath);

        // Преобразование данных в массив
        $players = json_decode($jsonData, true);

        // Вставка данных в таблицу
        DB::table('players')->insert($players);
    }
}
