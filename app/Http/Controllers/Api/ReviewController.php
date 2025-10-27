<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * @OA\Tag(
 *     name="Reviews",
 *     description="Gestión de reseñas y valoraciones de videojuegos"
 * )
 */
class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Listar todas las reseñas",
     *     tags={"Reviews"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de reseñas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Review"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Review::all());
    }

    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Crear una nueva reseña",
     *     tags={"Reviews"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","game_id","rating","comment"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="game_id", type="integer"),
     *             @OA\Property(property="rating", type="integer", example=5),
     *             @OA\Property(property="comment", type="string", example="Excelente juego con una historia impresionante.")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Reseña creada", @OA\JsonContent(ref="#/components/schemas/Review"))
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'game_id' => 'required|integer|exists:games,id',
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::create($validated);
        return response()->json($review, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/reviews/{id}",
     *     summary="Obtener una reseña por ID",
     *     tags={"Reviews"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Reseña encontrada", @OA\JsonContent(ref="#/components/schemas/Review")),
     *     @OA\Response(response=404, description="No encontrada")
     * )
     */
    public function show($id)
    {
        $review = Review::find($id);
        return $review ? response()->json($review) : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/reviews/{id}",
     *     summary="Actualizar una reseña",
     *     tags={"Reviews"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="integer", example=8),
     *             @OA\Property(property="comment", type="string", example="Buena jugabilidad pero historia débil.")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Reseña actualizada", @OA\JsonContent(ref="#/components/schemas/Review"))
     * )
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) return response()->json(['message' => 'Not found'], 404);

        $review->update($request->only(['rating', 'comment']));
        return response()->json($review);
    }

    /**
     * @OA\Delete(
     *     path="/api/reviews/{id}",
     *     summary="Eliminar una reseña",
     *     tags={"Reviews"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Eliminada correctamente")
     * )
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) return response()->json(['message' => 'Not found'], 404);

        $review->delete();
        return response()->noContent();
    }
}
