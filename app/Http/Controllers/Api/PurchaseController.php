<?php

namespace App\Http\Controllers\Api;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Purchases",
 *     description="Gestión de compras realizadas por usuarios"
 * )
 */
class PurchaseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/purchases",
     *     summary="Listar compras del usuario autenticado",
     *     description="Devuelve todas las compras asociadas al usuario autenticado. Incluye información del videojuego relacionado.",
     *     tags={"Purchases"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de compras obtenida correctamente",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Purchase"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $purchases = Purchase::where('user_id', $user->id)
            ->with('game')
            ->get();

        return response()->json($purchases);
    }

    /**
     * @OA\Post(
     *     path="/api/purchases",
     *     summary="Registrar una nueva compra",
     *     description="Permite registrar una nueva compra de un videojuego realizada por un usuario.",
     *     tags={"Purchases"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","game_id","price"},
     *             @OA\Property(property="user_id", type="integer", example=3, description="ID del usuario que realiza la compra"),
     *             @OA\Property(property="game_id", type="integer", example=8, description="ID del videojuego comprado"),
     *             @OA\Property(property="price", type="number", format="float", example=39.99, description="Precio del videojuego al momento de la compra")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Compra registrada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Purchase")
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
            'user_id' => 'required|integer|exists:users,id',
            'game_id' => 'required|integer|exists:games,id',
            'price' => 'required|decimal:0,2|min:1'
        ]);

        $purchase = Purchase::create($validated);
        return response()->json($purchase, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/purchases/{id}",
     *     summary="Obtener una compra específica",
     *     description="Devuelve los detalles de una compra mediante su ID.",
     *     tags={"Purchases"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la compra",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Compra encontrada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Purchase")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function show($id)
    {
        $purchase = Purchase::find($id);
        return $purchase
            ? response()->json($purchase)
            : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/purchases/{id}",
     *     summary="Actualizar el precio de una compra",
     *     description="Permite modificar el precio registrado en una compra existente.",
     *     tags={"Purchases"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la compra a actualizar",
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="price", type="number", format="float", example=59.99)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Compra actualizada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Purchase")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase)
            return response()->json(['message' => 'Not found'], 404);

        $purchase->update($request->only(['price']));
        return response()->json($purchase);
    }

    /**
     * @OA\Delete(
     *     path="/api/purchases/{id}",
     *     summary="Eliminar una compra",
     *     description="Elimina una compra registrada en el sistema mediante su ID.",
     *     tags={"Purchases"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la compra a eliminar",
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Compra eliminada correctamente (sin contenido)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase)
            return response()->json(['message' => 'Not found'], 404);

        $purchase->delete();
        return response()->noContent();
    }
}
