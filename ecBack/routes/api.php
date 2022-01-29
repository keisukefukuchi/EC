<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaserController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewImageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\HistoryController;

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
Route::middleware('auth:purchaser')->get('/purchaser/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:seller')->get('/seller/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'purchaser'], function () {
    Route::post('/login', [PurchaserController::class, 'login']);
    Route::post('/logout', [PurchaserController::class, 'logout']);
    Route::post('/register', [PurchaserController::class, 'register']);
    Route::post('/update', [PurchaserController::class, 'update']);
    Route::post('/update-image', [PurchaserController::class, 'updateImage']);
});

Route::group(['prefix' => 'seller'], function () {
    Route::post('/login', [SellerController::class, 'login']);
    Route::post('/logout', [SellerController::class, 'logout']);
    Route::post('/register', [SellerController::class, 'register']);
    Route::get('/stripe', [SellerController::class, 'stripe']);
});

Route::group(['prefix' => 'top'], function () {
    Route::get('/item', [ItemController::class, 'index_public8']);
    Route::get('/item/recommend', [ItemController::class, 'recommend4']);
    Route::get('/item/ranking', [ItemController::class, 'ranking5']);
    Route::get('/review', [ReviewController::class, 'index4']);
});

Route::get('item', [ItemController::class, 'index']);
Route::get('item_public', [ItemController::class, 'index_public']);
Route::get('item/{id}', [ItemController::class, 'show']);
Route::post('/item/recommend', [ItemController::class, 'recommend']);
Route::post('/item/ranking', [ItemController::class, 'ranking']);
Route::get('item/category/{id}', [ItemController::class, 'category']);
Route::post('item/register', [ItemController::class, 'register']);
Route::post('item/update', [ItemController::class, 'update']);

Route::post('item-image/register', [ItemImageController::class, 'register']);

Route::post('favorite/create', [FavoriteController::class, 'saveOrDelete']);
Route::get('favorite/show', [FavoriteController::class, 'show']);
Route::get('favorite/items', [FavoriteController::class, 'favoriteItems']);


Route::get('cart/show/{id}', [CartController::class, 'show']);
Route::post('cart/update', [CartController::class, 'update']);
Route::post('cart/plus', [CartController::class, 'plus']);
Route::post('cart/add', [CartController::class, 'add']);
Route::post('cart/destroy', [CartController::class, 'destroy']);
Route::post('cart/purchase', [CartController::class, 'purchase']);

Route::post('purchase/store', [PurchaseController::class, 'store']);
Route::get('purchase/index/{id}', [PurchaseController::class, 'index']);
Route::get('purchase/show/{id}', [PurchaseController::class, 'show']);
Route::post('history/store', [HistoryController::class, 'store']);

Route::get('review/{item_id}', [ReviewController::class, 'index']);
Route::get('top/review', [ReviewController::class, 'evaluation']);
Route::post('review/register', [ReviewController::class, 'register']);

Route::post('review-image/register', [ReviewImageController::class, 'register']);