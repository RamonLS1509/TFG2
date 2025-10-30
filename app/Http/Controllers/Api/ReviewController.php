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
     *     description="Devuelve una lista completa de todas las reseñas y valoraciones realizadas por los usuarios.",
     *     tags={"Reviews"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de reseñas obtenida correctamente",
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
     *     description="Permite a un usuario crear una reseña para un videojuego, incluyendo una calificación numérica y un comentario.",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","game_id","rating","comment"},
     *             @OA\Property(property="user_id", type="integer", example=5, description="ID del usuario que realiza la reseña"),
     *             @OA\Property(property="game_id", type="integer", example=12, description="ID del videojuego reseñado"),
     *             @OA\Property(property="rating", type="integer", minimum=1, maximum=10, example=8, description="Puntuación otorgada al videojuego"),
     *             @OA\Property(property="comment", type="string", maxLength=1000, example="Excelente juego con una historia muy envolvente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reseña creada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
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
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::create($validated);
        return response()->json($review, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/reviews/{id}",
     *     summary="Obtener una reseña específica",
     *     description="Devuelve los detalles de una reseña concreta, incluyendo la valoración y comentario.",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la reseña",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reseña encontrada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reseña no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $review = Review::find($id);
        return $review
            ? response()->json($review)
            : response()->json(['message' => 'Not found'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/reviews/{id}",
     *     summary="Actualizar una reseña",
     *     description="Permite modificar la puntuación o el comentario de una reseña existente.",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la reseña a actualizar",
     *         @OA\Schema(type="integer", example=7)
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="integer", minimum=1, maximum=10, example=9),
     *             @OA\Property(property="comment", type="string", example="Tras el parche, el rendimiento mejoró mucho.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reseña actualizada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reseña no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review)
            return response()->json(['message' => 'Not found'], 404);

        $review->update($request->only(['rating', 'comment']));
        return response()->json($review);
    }

    /**
     * @OA\Delete(
     *     path="/api/reviews/{id}",
     *     summary="Eliminar una reseña",
     *     description="Permite eliminar una reseña del sistema mediante su ID.",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la reseña a eliminar",
     *         @OA\Schema(type="integer", example=7)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Reseña eliminada correctamente (sin contenido)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reseña no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token no válido o usuario no autenticado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review)
            return response()->json(['message' => 'Not found'], 404);

        $review->delete();
        return response()->noContent();
    }
}
