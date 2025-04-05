<?php

use App\Http\Controllers\PengurusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\AnggotaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function(){
    return response([
        'pesan'=> 'API siap',
    ]);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(['auth:sanctum', 'role:pengawas'])->group(function () {
        Route::get('/dashboard/pengawas', [PengawasController::class, 'index']);
    });

    Route::middleware(['auth:sanctum', 'role:pengurus'])->group(function () {
        Route::get('/dashboard/pengurus', [PengurusController::class, 'index']);
        Route::get('/anggota/pending', [PengurusController::class, 'listPendingAnggota']);
        Route::post('/anggota/{id}/approve', [PengurusController::class, 'approveAnggota']);
        Route::post('/anggota/{id}/reject', [PengurusController::class, 'rejectAnggota']);
    });
    

    Route::middleware('role:anggota')->group(function () {
        Route::get('/dashboard/anggota', [AnggotaController::class, 'index']);
    });
});
