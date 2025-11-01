<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Presensi API Routes
Route::middleware('web')->group(function () {
    // QR Code verification and save attendance
    Route::post('/presensi/verify', [PresensiController::class, 'verify'])->name('api.presensi.verify');
    
    // Get attendance history for logged user
    Route::get('/presensi/history', [PresensiController::class, 'history'])->name('api.presensi.history');
    
    // Get today's scans for display
    Route::get('/presensi/today', [PresensiController::class, 'todayScans'])->name('api.presensi.today');
});
