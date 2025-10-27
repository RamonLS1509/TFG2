<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Purchase;
use App\Models\Game;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    // POST /api/purchases  (autenticado)
    public function store(StorePurchaseRequest $request)
    {
        $user = $request->user();
        $game = Game::findOrFail($request->game_id);

        // Avoid duplicate purchases
        if ($user->purchases()->where('game_id',$game->id)->exists()) {
            return response()->json(['message'=>'Ya comprado'], 409);
        }

        $purchase = $user->purchases()->create([
            'game_id' => $game->id,
            'price' => $request->price,
            'purchased_at' => Carbon::now()
        ]);

        return response()->json($purchase, 201);
    }

    // GET /api/users/{user}/purchases (private; user or admin)
    public function index(Request $request)
    {
        $user = $request->user();
        $purchases = $user->purchases()->with('game')->paginate(12);
        return response()->json($purchases, 200);
    }
}
