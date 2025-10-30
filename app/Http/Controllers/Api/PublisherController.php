<?php

namespace App\Http\Controllers\Api;

use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Publishers",
 *     description="Gestión de editores o distribuidores de videojuegos"
 * )
 */
class PublisherController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/publishers",
     *     summary="Listar todos los editores/distribuidores",
     *     description="Obtiene la lista completa de editores o distribuidores de videojuegos registrados.",
     *     tags={"Publishers"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de editores obtenida correctamente",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Publisher"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Publisher::all());
    }

    /**
     * @OA\Post(
     *     path="/api/publishers",
     *     summary="Crear un nuevo editor/distribuidor",
     *     description="Crea un nuevo registro de editor o distribuidor de videojuegos.",
     *     tags={"Publishers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Sony Interactive Entertainment"),
     *             @OA\Property(property="info", type="string", example="División de entretenimiento digital de Sony."),
     *             @OA\Property(property="website", type="string", example="https://www.sie.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Editor/distribuidor creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Publisher")
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
            'info' => 'string|max:255',
            'website' => 'string|max:255'
        ]);

        $publisher = Publisher::create($validated);
        return response()->json($publisher, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/publishers/{id}",
     *     summary="Obtener un editor/distribuidor específico",
     *     description="Devuelve los detalles de un editor o distribuidor de videojuegos por su ID.",
     *     tags={"Publishers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del editor/distribuidor",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Editor/distribuidor encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Publisher")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Editor/distribuidor no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $publisher = Publisher::find($id);
        return $publisher
            ? response()->json($publisher)
            : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/publishers/{id}",
     *     summary="Actualizar un editor/distribuidor",
     *     description="Actualiza los datos de un editor o distribuidor de videojuegos existente.",
     *     tags={"Publishers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del editor/distribuidor a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Ubisoft Entertainment"),
     *             @OA\Property(property="info", type="string", example="Compañía francesa de desarrollo y distribución de videojuegos."),
     *             @OA\Property(property="website", type="string", example="https://www.ubisoft.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Editor/distribuidor actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Publisher")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Editor/distribuidor no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
     *     summary="Eliminar un editor/distribuidor",
     *     description="Elimina un editor o distribuidor de videojuegos de la base de datos.",
     *     tags={"Publishers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del editor/distribuidor a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Editor/distribuidor eliminado correctamente (sin contenido)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Editor/distribuidor no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
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
