<?php

namespace App\Http\Controllers\Api;

use App\Models\Developer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * @OA\Tag(name="Developers", description="Gestión de desarrolladores de videojuegos")
 */
class DeveloperController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/developers",
     *     summary="Listar todos los desarrolladores",
     *     tags={"Developers"},
     *     @OA\Response(response=200, description="Lista de desarrolladores", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Developer")))
     * )
     */
    public function index()
    {
        return response()->json(Developer::all());
    }

    /**
     * @OA\Post(
     *     path="/api/developers",
     *     summary="Crear un nuevo desarrollador",
     *     tags={"Developers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Developer")),
     *     @OA\Response(response=201, description="Desarrollador creado", @OA\JsonContent(ref="#/components/schemas/Developer"))
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $developer = Developer::create($validated);
        return response()->json($developer, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/developers/{id}",
     *     summary="Obtener un desarrollador",
     *     tags={"Developers"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Desarrollador encontrado", @OA\JsonContent(ref="#/components/schemas/Developer")),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show($id)
    {
        $developer = Developer::find($id);
        return $developer ? response()->json($developer) : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/developers/{id}",
     *     summary="Actualizar un desarrollador",
     *     tags={"Developers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Developer")),
     *     @OA\Response(response=200, description="Desarrollador actualizado", @OA\JsonContent(ref="#/components/schemas/Developer"))
     * )
     */
    public function update(Request $request, $id)
    {
        $developer = Developer::find($id);
        if (!$developer) return response()->json(['message' => 'Not found'], 404);
        $developer->update($request->all());
        return response()->json($developer);
    }

    /**
     * @OA\Delete(
     *     path="/api/developers/{id}",
     *     summary="Eliminar un desarrollador",
     *     tags={"Developers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminado correctamente")
     * )
     */
    public function destroy($id)
    {
        $developer = Developer::find($id);
        if (!$developer) return response()->json(['message' => 'Not found'], 404);
        $developer->delete();
        return response()->noContent();
    }
}
