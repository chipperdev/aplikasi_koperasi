<?php

use App\Http\Controllers\PengurusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This is where you can register all of your API routes. 
| It's a good idea to keep these routes organized and grouped accordingly.
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Test route to check if the API is up
Route::get('/test', function () {
    return response(['pesan' => 'API siap']);
});

// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Role-based routes
    Route::middleware('role:pengawas')->group(function () {
        // Routes for Pengawas
        Route::get('/dashboard/pengawas', [PengawasController::class, 'index']);
    });

    Route::middleware('role:pengurus')->group(function () {
        // Routes for Pengurus
        Route::get('/dashboard/pengurus', [PengurusController::class, 'index']);
        
        // Manage Anggota
        Route::get('/anggota/pending', [PengurusController::class, 'listPendingAnggota']);
        Route::post('/anggota/{id}/approve', [PengurusController::class, 'approveAnggota']);
        Route::post('/anggota/{id}/reject', [PengurusController::class, 'rejectAnggota']);
        Route::delete('/anggota/{id}/hapus', [PengurusController::class, 'hapusAnggota']);
        Route::get('/pengurus/jumlah-anggota', [PengurusController::class, 'jumlahAnggota']);
        Route::get('/anggota/{id}/status', [PengurusController::class, 'detailStatusPendaftaran']);
    });

    Route::middleware('role:anggota')->group(function () {
        // Routes for Anggota
        Route::get('/dashboard/anggota', [AnggotaController::class, 'index']);
        Route::get('/anggota/status', [AnggotaController::class, 'statusPendaftaranSaya']);
    });
});
