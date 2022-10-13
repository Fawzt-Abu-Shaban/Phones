<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\FivoritController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('login', [ApiAuthController::class, 'login']);
    Route::post('register', [ApiAuthController::class, 'register']);
    Route::post('forgot-Password', [ApiAuthController::class, 'forgotPassword']);
});

Route::prefix('auth')->middleware(['auth:api', 'verified'])->group(function () {
    Route::post('change-Password', [ApiAuthController::class, 'changePassword']);
    Route::get('logout', [ApiAuthController::class, 'logout']);
});

Route::prefix('mobile')->group(function () {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('type', TypeController::class);
    Route::apiResource('slider', SliderController::class);
    Route::apiResource('product', ProductController::class);
    // Route::get('search', [SearchController::class, 'searching']);
});

Route::prefix('mobile')->middleware(['auth:api', 'verified'])->group(function () {
    Route::get('favorite', [FivoritController::class, 'showFavorite']);
    Route::post('favorite/{id}', [FivoritController::class, 'favoriteProduct']);
});

Route::prefix('mobile')->middleware(['auth:api', 'verified'])->group(function () {
    Route::get('cart', [FivoritController::class, 'showCart']);
    Route::post('cart/{id}', [FivoritController::class, 'cartProduct']);
    Route::post('increment/{id}', [FivoritController::class, 'increaseQuantity']);
    Route::post('decrement/{id}', [FivoritController::class, 'decreaseQuantity']);
    Route::post('checkout', [FivoritController::class, 'checkout']);
});
