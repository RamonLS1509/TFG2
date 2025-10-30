<?php

namespace App\Http\Controllers\Api;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Genres",
 *     description="Gestión de géneros de videojuegos"
 * )
 */
class GenreController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/genres",
     *     summary="Listar todos los géneros",
     *     description="Devuelve una lista completa de los géneros de videojuegos registrados.",
     *     tags={"Genres"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de géneros obtenida correctamente",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Genre"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Genre::all());
    }

    /**
     * @OA\Post(
     *     path="/api/genres",
     *     summary="Crear un nuevo género",
     *     description="Crea un nuevo registro de género de videojuego en la base de datos.",
     *     tags={"Genres"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Acción"),
     *             @OA\Property(property="description", type="string", example="Juegos enfocados en la acción y reflejos del jugador.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Género creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
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
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $genre = Genre::create($validated);
        return response()->json($genre, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/genres/{id}",
     *     summary="Obtener un género específico",
     *     description="Devuelve la información detallada de un género de videojuego mediante su ID.",
     *     tags={"Genres"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del género",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Género encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Género no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $genre = Genre::find($id);
        return $genre
            ? response()->json($genre)
            : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/genres/{id}",
     *     summary="Actualizar un género existente",
     *     description="Actualiza los datos de un género de videojuego existente.",
     *     tags={"Genres"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del género a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Aventura"),
     *             @OA\Property(property="description", type="string", example="Género centrado en la exploración y narrativa.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Género actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Genre")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Género no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if (!$genre) return response()->json(['message' => 'Not found'], 404);

        $genre->update($request->all());
        return response()->json($genre);
    }

    /**
     * @OA\Delete(
     *     path="/api/genres/{id}",
     *     summary="Eliminar un género",
     *     description="Elimina un género de videojuego del sistema mediante su ID.",
     *     tags={"Genres"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del género a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Género eliminado correctamente (sin contenido)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Género no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (!$genre) return response()->json(['message' => 'Not found'], 404);

        $genre->delete();
        return response()->noContent();
    }
}
