<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Список всех игр
    public function index()
    {
        $games = Game::with([
            'teams.players' => function ($query) {
                $query->orderBy('rating', 'desc'); // Сортировка игроков по убыванию рейтинга
            }
        ])->orderByDesc('created_at')->get();
        return view('games.index', compact('games')); // Возврат на страницу списка игр
    }

    // Форма создания новой игры
    public function create()
    {
        $players = Player::all(); // Получение всех игроков
        return view('games.create', compact('players')); // Возврат формы создания игры
    }

    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'date' => 'required|date',
            'team_count' => 'required|integer|min:2',
            'is_balanced' => 'required|boolean',
            'players' => 'required|array|min:2', // Должно быть выбрано минимум 2 игрока
        ]);
        
        $isBalanced = $validated['is_balanced'];
        $teamsCount = $validated['team_count'];
        $players = Player::whereIn('id', $validated['players'])->get();

        // Создаем пустой массив для команд
        $teams = collect(range(1, $teamsCount))->map(fn ($i) => collect());
        if ($isBalanced) {
            // Сбалансированное распределение
            // Сортируем игроков по рейтингу (от самого сильного к самому слабому)
            $players = $players->sortByDesc('rating');

            // Инициализируем массив для суммарных рейтингов команд
            $teamsRatings = array_fill(0, $teamsCount, 0); // Заполняем массив нулями, по количеству команд

            foreach ($players as $player) {
                // Находим команду с минимальным суммарным рейтингом
                $minTeamIndex = array_search(min($teamsRatings), $teamsRatings); // Находим индекс команды с минимальным рейтингом
                
                // Добавляем игрока в эту команду
                $teams[$minTeamIndex]->push($player);
                
                // Обновляем суммарный рейтинг этой команды
                $teamsRatings[$minTeamIndex] += $player->rating;
            }
        } else {
            // Случайное распределение
            $players = $players->shuffle(); // Перемешиваем игроков случайным образом
    
            foreach ($players as $index => $player) {
                // Добавляем игрока в команду с индексом (по кругу)
                $teams[$index % $teamsCount]->push($player);
            }
        }

        // Создание игры
        $game = Game::create([
            'date' => $validated['date'],
            'is_balanced' => $validated['is_balanced'],
            'name' => 'Игра ' . $validated['date'],
        ]);

        // Создание команд
        foreach ($teams as $playersInTeam) {
            $team = $game->teams()->create(); // game_id заполняется автоматически
            // $team->players()->sync($playersInTeam->pluck('id')); // Привязываем игроков к команде
            $team->players()->saveMany($playersInTeam); // Привязываем игроков к команде
        }

        // Перенаправление после успешного сохранения
        return redirect()->route('games.index')->with('success', 'Игра успешно создана.');
    }

    // Форма редактирования игры
    public function edit(Game $game)
    {
        $game->load('teams.players'); // Загрузка команд и игроков игры
        $players = Player::all(); // Все игроки

        return view('games.edit', compact('game', 'players'));
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        // Обновляем дату игры
        $game->update([
            'date' => $request->input('date'),
        ]);

        // Получаем данные команд из запроса
        $teamsData = $request->input('teams', []);

        // Считаем сумму очков всех команд
        $scoresOfAll = collect($teamsData)->sum(function ($teamData) {
            return (int) $teamData['score'];
        });

        // Если очки всех команд равны 0, завершаем выполнение
        if ($scoresOfAll === 0) {
            return redirect()->route('games.index')->with('success', 'Игра успешно обновлена.');
        }

        // Получаем команды одним запросом и загружаем игроков
        $teamIds = array_keys($teamsData);
        $teams = Team::whereIn('id', $teamIds)->with('players')->get();

        foreach ($teams as $team) {
            // Обновляем очки команды
            $team->update([
                'score' => $teamsData[$team->id]['score'],
            ]);

            // Обновляем рейтинг всех игроков команды
            foreach ($team->players as $player) {
                $player->recalculateRating();
            }
        }

        return redirect()->route('games.index')->with('success', 'Игра успешно обновлена.');
    }

    // Удаление игры
    public function destroy(Game $game)
    {
        $game->delete(); // Мягкое удаление игры
        return redirect()->route('games.index')->with('success', 'Игра успешно удалена!');
    }
}
