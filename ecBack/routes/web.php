<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::post('/login', [PurchaserController::class, 'login']);
// Route::post('/logout', [PurchaserController::class, 'logout']);
// Route::post('/register', [PurchaserController::class, 'register']);