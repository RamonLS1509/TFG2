<?php

namespace App\Http\Controllers\Api;

use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * @OA\Tag(name="Platforms", description="Gestión de plataformas de videojuegos")
 */
class PlatformController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/platforms",
     *     summary="Listar todas las plataformas",
     *     tags={"Platforms"},
     *     @OA\Response(response=200, description="Lista de plataformas", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Platform")))
     * )
     */
    public function index()
    {
        return response()->json(Platform::all());
    }

    /**
     * @OA\Post(
     *     path="/api/platforms",
     *     summary="Crear una nueva plataforma",
     *     tags={"Platforms"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Platform")),
     *     @OA\Response(response=201, description="Plataforma creada", @OA\JsonContent(ref="#/components/schemas/Platform"))
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $platform = Platform::create($validated);
        return response()->json($platform, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/platforms/{id}",
     *     summary="Obtener detalles de una plataforma",
     *     tags={"Platforms"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Plataforma encontrada", @OA\JsonContent(ref="#/components/schemas/Platform")),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show($id)
    {
        $platform = Platform::find($id);
        return $platform ? response()->json($platform) : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/platforms/{id}",
     *     summary="Actualizar una plataforma",
     *     tags={"Platforms"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Platform")),
     *     @OA\Response(response=200, description="Plataforma actualizada", @OA\JsonContent(ref="#/components/schemas/Platform"))
     * )
     */
    public function update(Request $request, $id)
    {
        $platform = Platform::find($id);
        if (!$platform) return response()->json(['message' => 'Not found'], 404);
        $platform->update($request->all());
        return response()->json($platform);
    }

    /**
     * @OA\Delete(
     *     path="/api/platforms/{id}",
     *     summary="Eliminar una plataforma",
     *     tags={"Platforms"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminado correctamente")
     * )
     */
    public function destroy($id)
    {
        $platform = Platform::find($id);
        if (!$platform) return response()->json(['message' => 'Not found'], 404);
        $platform->delete();
        return response()->noContent();
    }
}
