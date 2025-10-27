<?php

namespace App\Http\Controllers\Api;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * @OA\Tag(
 *     name="Games",
 *     description="Gestión de videojuegos"
 * )
 */
class GameController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/games",
     *     summary="Listar todos los videojuegos",
     *     tags={"Games"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de videojuegos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Game"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Game::all());
    }

    /**
     * @OA\Post(
     *     path="/api/games",
     *     summary="Crear un nuevo videojuego",
     *     tags={"Games"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Videojuego creado",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'genre_id' => 'required|integer',
            'platform_id' => 'required|integer',
            'developer_id' => 'required|integer',
            'publisher_id' => 'required|integer',
        ]);

        $game = Game::create($validated);
        return response()->json($game, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/games/{id}",
     *     summary="Obtener detalles de un videojuego",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del videojuego",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del videojuego",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(response=404, description="Videojuego no encontrado")
     * )
     */
    public function show($id)
    {
        $game = Game::find($id);
        if (!$game) return response()->json(['message' => 'Not found'], 404);
        return response()->json($game);
    }

    /**
     * @OA\Put(
     *     path="/api/games/{id}",
     *     summary="Actualizar un videojuego",
     *     tags={"Games"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id", in="path", required=true,
     *         description="ID del videojuego",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Game")),
     *     @OA\Response(response=200, description="Videojuego actualizado", @OA\JsonContent(ref="#/components/schemas/Game")),
     *     @OA\Response(response=404, description="Videojuego no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $game = Game::find($id);
        if (!$game) return response()->json(['message' => 'Not found'], 404);
        $game->update($request->all());
        return response()->json($game);
    }

    /**
     * @OA\Delete(
     *     path="/api/games/{id}",
     *     summary="Eliminar un videojuego",
     *     tags={"Games"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del videojuego", @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminado correctamente"),
     *     @OA\Response(response=404, description="Videojuego no encontrado")
     * )
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        if (!$game) return response()->json(['message' => 'Not found'], 404);
        $game->delete();
        return response()->noContent();
    }
}
