<?php

namespace App\Http\Controllers\Api;

use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Platforms",
 *     description="Gestión de plataformas de videojuegos"
 * )
 */
class PlatformController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/platforms",
     *     summary="Listar todas las plataformas",
     *     description="Devuelve una lista completa de las plataformas de videojuegos registradas.",
     *     tags={"Platforms"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de plataformas obtenida correctamente",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Platform"))
     *     )
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
     *     description="Crea una nueva plataforma de videojuegos.",
     *     tags={"Platforms"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="PlayStation 5")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Plataforma creada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Platform")
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
        ]);

        $platform = Platform::create($validated);
        return response()->json($platform, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/platforms/{id}",
     *     summary="Obtener una plataforma específica",
     *     description="Devuelve los detalles de una plataforma de videojuegos mediante su ID.",
     *     tags={"Platforms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plataforma encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Platform")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plataforma no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $platform = Platform::find($id);
        return $platform
            ? response()->json($platform)
            : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/platforms/{id}",
     *     summary="Actualizar una plataforma existente",
     *     description="Actualiza los datos de una plataforma de videojuegos.",
     *     tags={"Platforms"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Xbox Series X")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plataforma actualizada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Platform")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plataforma no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
     *     description="Elimina una plataforma de videojuegos mediante su ID.",
     *     tags={"Platforms"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Plataforma eliminada correctamente (sin contenido)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plataforma no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
