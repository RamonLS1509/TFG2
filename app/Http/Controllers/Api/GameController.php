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
     *     description="Obtiene un listado completo de todos los videojuegos registrados.",
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
     *     description="Crea un nuevo registro de videojuego en la base de datos.",
     *     tags={"Games"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","slug","developer_id","publisher_id","genre_id","platform_id","release_date","price","description"},
     *             @OA\Property(property="title", type="string", example="Kingdom Hearts"),
     *             @OA\Property(property="slug", type="string", example="kingdom-hearts"),
     *             @OA\Property(property="developer_id", type="integer", example=3),
     *             @OA\Property(property="publisher_id", type="integer", example=4),
     *             @OA\Property(property="genre_id", type="integer", example=2),
     *             @OA\Property(property="platform_id", type="integer", example=1),
     *             @OA\Property(property="release_date", type="string", format="date", example="2020-06-19"),
     *             @OA\Property(property="price", type="number", format="float", example=39.99),
     *             @OA\Property(property="description", type="string", example="Juego de acción y aventura con historia envolvente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Videojuego creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación en los datos enviados"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'developer_id' => 'required|integer',
            'publisher_id' => 'required|integer',
            'genre_id' => 'required|integer',
            'platform_id' => 'required|integer',
            'release_date' => 'required|date',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'description' => 'required|string|max:255',
        ]);

        $game = Game::create($validated);
        return response()->json($game, 201);
    }

 /**
     * @OA\Get(
     *     path="/api/games/{id}",
     *     summary="Obtener un videojuego por ID",
     *     description="Devuelve la información de un videojuego específico mediante su ID.",
     *     tags={"Games"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del videojuego",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Videojuego encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Videojuego no encontrado"
     *     )
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
     *     summary="Actualizar un videojuego existente",
     *     description="Actualiza los datos de un videojuego ya existente en la base de datos.",
     *     tags={"Games"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del videojuego a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Kingdom Hearts II"),
     *             @OA\Property(property="slug", type="string", example="kingdom-hearts-2"),
     *             @OA\Property(property="price", type="number", format="float", example=49.99),
     *             @OA\Property(property="description", type="string", example="Secuela del aclamado RPG de acción.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Videojuego actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Videojuego no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
     *     description="Elimina un videojuego del sistema por su ID.",
     *     tags={"Games"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del videojuego a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Videojuego eliminado correctamente (sin contenido)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Videojuego no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
