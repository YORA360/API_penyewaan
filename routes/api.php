<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PelangganDataController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenyewaanDetailController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\AuthController;
use App\Http\controllers\AdminController;
use Illuminate\Support\Facades\Password;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Tambahkan name('login')
Route::post('/register', [AuthController::class, 'register']);

Route::post('/admin', [AdminController::class, 'login']);

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/reset-password/{token}', function ($token) {
    return response()->json(['token' => $token, 'message' => 'Use this token to reset password']);
})->name('password.reset');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/auth/refresh', [AuthController::class, 'refreshToken']);
    Route::apiResource('/kategori', KategoriController::class);
    Route::apiResource('/data/pelanggan', PelangganDataController::class);
    Route::apiResource('/pelanggan', PelangganController::class);
    Route::apiResource('/detail/penyewaan', PenyewaanDetailController::class);
    Route::apiResource('/penyewaan', PenyewaanController::class);
    Route::apiResource('/alat', AlatController::class);
});
