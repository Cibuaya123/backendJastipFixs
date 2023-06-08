<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;

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
Route::post('/register', [UserController::class, 'registerUser'])->name('user.register');
Route::post('/login', [UserController::class, 'loginUser'])->name('user.login');
// Rute untuk menampilkan daftar produk
Route::get('/produk', [ProdukController::class, 'index']);

// Rute untuk menampilkan detail produk
Route::get('/produk/{id}', [ProdukController::class, 'show']);

// Rute untuk membuat produk baru
Route::post('/produk', [ProdukController::class, 'store']);

// Rute untuk memperbarui data produk
Route::put('/produk/{id}', [ProdukController::class, 'update']);

// Rute untuk menghapus produk  
Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
