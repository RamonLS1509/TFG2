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
     *     summary="Listar todas las compras",
     *     tags={"Purchases"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de compras",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Purchase"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Devuelve solo las compras del usuario autenticado
        $purchases = Purchase::where('user_id', $user->id)
            ->with('game')
            ->get();

        return response()->json($purchases);
    }

    /**
     * @OA\Post(
     *     path="/api/purchases",
     *     summary="Registrar una nueva compra",
     *     tags={"Purchases"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","game_id","price","total_price"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="game_id", type="integer", example=2),
     *             @OA\Property(property="price", type="decimal", example=1),
     *             @OA\Property(property="total_price", type="number", format="float", example=59.99)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Compra registrada", @OA\JsonContent(ref="#/components/schemas/Purchase"))
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
     *     summary="Obtener detalles de una compra",
     *     tags={"Purchases"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Compra encontrada", @OA\JsonContent(ref="#/components/schemas/Purchase")),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show($id)
    {
        $purchase = Purchase::find($id);
        return $purchase ? response()->json($purchase) : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/purchases/{id}",
     *     summary="Actualizar una compra",
     *     tags={"Purchases"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="price", type="decimal", example=2),
     *             @OA\Property(property="total_price", type="number", format="float", example=119.98)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Compra actualizada", @OA\JsonContent(ref="#/components/schemas/Purchase"))
     * )
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase)
            return response()->json(['message' => 'Not found'], 404);

        $purchase->update($request->only(['price', 'total_price']));
        return response()->json($purchase);
    }

    /**
     * @OA\Delete(
     *     path="/api/purchases/{id}",
     *     summary="Eliminar una compra",
     *     tags={"Purchases"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminada correctamente")
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
