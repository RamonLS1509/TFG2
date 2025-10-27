<?php

namespace App\Http\Controllers\Api;

use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * @OA\Tag(name="Publishers", description="Gestión de editores/distribuidores de videojuegos")
 */
class PublisherController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/publishers",
     *     summary="Listar todos los editores",
     *     tags={"Publishers"},
     *     @OA\Response(response=200, description="Lista de editores", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Publisher")))
     * )
     */
    public function index()
    {
        return response()->json(Publisher::all());
    }

    /**
     * @OA\Post(
     *     path="/api/publishers",
     *     summary="Crear un nuevo editor",
     *     tags={"Publishers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Publisher")),
     *     @OA\Response(response=201, description="Editor creado", @OA\JsonContent(ref="#/components/schemas/Publisher"))
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $publisher = Publisher::create($validated);
        return response()->json($publisher, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/publishers/{id}",
     *     summary="Obtener un editor",
     *     tags={"Publishers"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Editor encontrado", @OA\JsonContent(ref="#/components/schemas/Publisher")),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show($id)
    {
        $publisher = Publisher::find($id);
        return $publisher ? response()->json($publisher) : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/publishers/{id}",
     *     summary="Actualizar un editor",
     *     tags={"Publishers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Publisher")),
     *     @OA\Response(response=200, description="Editor actualizado", @OA\JsonContent(ref="#/components/schemas/Publisher"))
     * )
     */
    public function update(Request $request, $id)
    {
        $publisher = Publisher::find($id);
        if (!$publisher) return response()->json(['message' => 'Not found'], 404);
        $publisher->update($request->all());
        return response()->json($publisher);
    }

    /**
     * @OA\Delete(
     *     path="/api/publishers/{id}",
     *     summary="Eliminar un editor",
     *     tags={"Publishers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminado correctamente")
     * )
     */
    public function destroy($id)
    {
        $publisher = Publisher::find($id);
        if (!$publisher) return response()->json(['message' => 'Not found'], 404);
        $publisher->delete();
        return response()->noContent();
    }
}
