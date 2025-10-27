<?php

namespace App\Http\Controllers\Api;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * @OA\Tag(name="Genres", description="Gestión de géneros de videojuegos")
 */
class GenreController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/genres",
     *     summary="Listar todos los géneros",
     *     tags={"Genres"},
     *     @OA\Response(response=200, description="Lista de géneros", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Genre")))
     * )
     */
    public function index() { return response()->json(Genre::all()); }

    /**
     * @OA\Post(
     *     path="/api/genres",
     *     summary="Crear un nuevo género",
     *     tags={"Genres"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Genre")),
     *     @OA\Response(response=201, description="Género creado", @OA\JsonContent(ref="#/components/schemas/Genre"))
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        $genre = Genre::create($validated);
        return response()->json($genre, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/genres/{id}",
     *     summary="Obtener un género",
     *     tags={"Genres"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Género encontrado", @OA\JsonContent(ref="#/components/schemas/Genre")),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show($id)
    {
        $genre = Genre::find($id);
        return $genre ? response()->json($genre) : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/genres/{id}",
     *     summary="Actualizar un género",
     *     tags={"Genres"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Genre")),
     *     @OA\Response(response=200, description="Actualizado correctamente", @OA\JsonContent(ref="#/components/schemas/Genre"))
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
     *     tags={"Genres"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminado correctamente")
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
