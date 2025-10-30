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
     *     description="Devuelve un listado completo de los desarrolladores registrados en el sistema.",
     *     tags={"Developers"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de desarrolladores",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Developer"))
     *     )
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
     *     description="Crea un nuevo registro de desarrollador de videojuegos.",
     *     tags={"Developers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Naughty Dog"),
     *             @OA\Property(property="bio", type="string", example="Estudio californiano especializado en acción y aventura."),
     *             @OA\Property(property="website", type="string", example="https://www.naughtydog.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Desarrollador creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Developer")
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
            'bio' => 'string|max:255',
            'website' => 'string|max:255'
        ]);

        $developer = Developer::create($validated);
        return response()->json($developer, 201);
    }

/**
     * @OA\Get(
     *     path="/api/developers/{id}",
     *     summary="Mostrar un desarrollador específico",
     *     description="Obtiene la información de un desarrollador por su ID.",
     *     tags={"Developers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del desarrollador",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Desarrollador encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Developer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Desarrollador no encontrado"
     *     )
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
     *     summary="Actualizar un desarrollador existente",
     *     description="Actualiza los datos de un desarrollador ya registrado.",
     *     tags={"Developers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del desarrollador a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Square Enix"),
     *             @OA\Property(property="bio", type="string", example="Estudio japonés de videojuegos"),
     *             @OA\Property(property="website", type="string", example="https://www.square-enix.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Desarrollador actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Developer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Desarrollador no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
     *     description="Elimina un desarrollador del sistema por su ID.",
     *     tags={"Developers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del desarrollador a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Desarrollador eliminado correctamente (sin contenido)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Desarrollador no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
