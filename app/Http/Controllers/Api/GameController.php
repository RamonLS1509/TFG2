<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use Illuminate\Support\Str;

class GameController extends Controller
{
    // GET /api/games  (public)
    public function index(Request $request)
    {
        $q = $request->query('q');
        $games = Game::with(['developer','publisher','genres','platforms'])
            ->when($q, fn($qB) => $qB->where('title','like','%'.$q.'%'))
            ->paginate(12);
        return response()->json($games, 200);
    }

    // GET /api/games/{game}  (public)
    public function show(Game $game)
    {
        $game->load(['developer','publisher','genres','platforms','reviews']);
        return response()->json($game, 200);
    }

    // POST /api/games (admin)
    public function store(StoreGameRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['slug'] ?? $data['title']);
        $game = Game::create($data);

        if (!empty($data['genres'])) $game->genres()->sync($data['genres']);
        if (!empty($data['platforms'])) $game->platforms()->sync($data['platforms']);

        return response()->json($game->load(['genres','platforms']), 201);
    }

    // PUT /api/games/{game} (admin)
    public function update(UpdateGameRequest $request, Game $game)
    {
        $data = $request->validated();
        if (isset($data['slug'])) $data['slug'] = Str::slug($data['slug']);
        $game->update($data);

        if (array_key_exists('genres',$data)) $game->genres()->sync($data['genres'] ?? []);
        if (array_key_exists('platforms',$data)) $game->platforms()->sync($data['platforms'] ?? []);

        return response()->json($game->load(['genres','platforms']), 200);
    }

    // DELETE /api/games/{game} (admin)
    public function destroy(Game $game)
    {
        $game->delete();
        return response()->json(null, 204);
    }
}
