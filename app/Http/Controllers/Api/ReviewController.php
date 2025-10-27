<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Game;

class ReviewController extends Controller
{
    // POST /api/games/{game}/reviews
    public function store(StoreReviewRequest $request, Game $game)
    {
        $user = $request->user();
        // ensure user hasn't already reviewed
        if ($game->reviews()->where('user_id',$user->id)->exists()) {
            return response()->json(['message'=>'Ya has reseñado este juego'], 409);
        }

        $review = $game->reviews()->create([
            'user_id' => $user->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment')
        ]);

        // business logic: recalcular average_rating
        $avg = $game->reviews()->avg('rating');
        $game->average_rating = round($avg, 2);
        $game->save();

        return response()->json($review->load('user'), 201);
    }

    // GET /api/games/{game}/reviews (public)
    public function index(Game $game)
    {
        $reviews = $game->reviews()->with('user')->paginate(10);
        return response()->json($reviews, 200);
    }

    // DELETE /api/reviews/{review} (auth: either owner or admin)
    public function destroy(Request $request, Review $review)
    {
        $user = $request->user();
        if ($user->id !== $review->user_id && !$user->hasRole('admin')) {
            return response()->json(['message'=>'Forbidden'], 403);
        }
        $game = $review->game;
        $review->delete();

        // recalcular rating
        $avg = $game->reviews()->avg('rating') ?? 0;
        $game->average_rating = round($avg,2);
        $game->save();

        return response()->json(null, 204);
    }
}
