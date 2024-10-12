<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\ruanganController;

Route::apiResource('pegawai', pegawaiController::class);
Route::apiResource('ruangan', ruanganController::class);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/pegawais', [pegawaiController::class, 'index']);
// Route::get('/pegawais/{nip}', [pegawaiController::class, 'show']);
// Route::post('/pegawais', [pegawaiController::class, 'store']);
// Route::put('/pegawais/{nip}', [pegawaiController::class, 'update']);
// Route::delete('/pegawais/{nip}', [pegawaiController::class, 'destroy']);

// Route::get('/ruangans', [ruanganController::class, 'index']);
// Route::get('/ruangans/{id_ruangan}', [ruanganController::class, 'show']);
// Route::post('/ruangans', [ruanganController::class, 'store']);
// Route::put('/ruangans/{id_ruangan}', [ruanganController::class, 'update']);
// Route::delete('/ruangans/{id_ruangan}', [ruanganController::class, 'destroy']);
