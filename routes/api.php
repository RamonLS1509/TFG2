<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\DeveloperController;
use App\Http\Controllers\Api\PublisherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Public routes
Route::get('games', [GameController::class, 'index']);
Route::get('games/{game}', [GameController::class, 'show']);
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('reviews/{game}', [ReviewController::class, 'index']);
Route::put('reviews/{review}', [ReviewController::class, 'update']);

// Public lists
Route::get('genres', [GenreController::class, 'index']);
Route::get('genres/{id}', [GenreController::class, 'show']);
Route::get('platforms', [PlatformController::class, 'index']);
Route::get('developers', [DeveloperController::class, 'index']);
Route::get('publishers', [PublisherController::class, 'index']);
// Protected routes
Route::middleware('auth:sanctum')->group(function () {
Route::post('logout', [AuthController::class, 'logout']);
Route::get('profile', [AuthController::class, 'profile']);
// User actions
Route::post('reviews', [ReviewController::class, 'store']);
Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);


// Admin routes (require role:admin middleware)

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('games', GameController::class)->except(['index', 'show']);
    Route::apiResource('genres', GenreController::class)->except(['index', 'show']);
    Route::apiResource('platforms', PlatformController::class)->except(['index']);
    Route::apiResource('developers', DeveloperController::class)->except(['index']);
    Route::apiResource('publishers', PublisherController::class)->except(['index']);
    Route::post('purchases', [PurchaseController::class, 'store']);
    Route::get('my/purchases', [PurchaseController::class, 'index']);
    Route::put('purchases/{purchase}', [PurchaseController::class, 'update']);
    Route::delete('purchases/{purchase}', [PurchaseController::class, 'destroy']);
    });
});
