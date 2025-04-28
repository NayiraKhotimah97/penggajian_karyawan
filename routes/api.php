<?php

use App\Http\Controllers\API\AbsensiSwaggerController;
use App\Http\Controllers\API\CategorySwaggerController;
use App\Http\Controllers\API\GajiSwaggerController;
use App\Http\Controllers\API\KaryawanSwaggerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\RiwayatPembayaranController;
use App\Http\Controllers\LaporanPembayaranController;

Route::apiResource('laporan-pembayarans', LaporanPembayaranController::class);
Route::apiResource('riwayat-pembayarans', RiwayatPembayaranController::class);
Route::apiResource('gajis', GajiController::class);
Route::apiResource('karyawans', KaryawanController::class);
Route::resource('absensis', AbsensiController::class);


Route::group([], function () {
    Route::get('category', [CategorySwaggerController::class, 'listCategory']);
});

Route::group([], function () {
    Route::get('absensi', [AbsensiSwaggerController::class, 'index']);
    Route::post('absensi', [AbsensiSwaggerController::class, 'store']);
    Route::get('absensi/{id}', [AbsensiSwaggerController::class, 'show']);
    Route::put('absensi/{id}', [AbsensiSwaggerController::class, 'update']);
    Route::delete('absensi/{id}', [AbsensiSwaggerController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('gajis', [GajiSwaggerController::class, 'index']);
    Route::post('gajis', [GajiSwaggerController::class, 'store']);
    Route::get('gajis/{gaji}', [GajiSwaggerController::class, 'show']);
    Route::put('gajis/{gaji}', [GajiSwaggerController::class, 'update']);
    Route::delete('gajis/{gaji}', [GajiSwaggerController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('karyawans', [KaryawanSwaggerController::class, 'index']);
    Route::post('karyawans', [KaryawanSwaggerController::class, 'store']);
    Route::get('karyawans/{karyawan}', [KaryawanSwaggerController::class, 'show']);
    Route::put('karyawans/{karyawan}', [KaryawanSwaggerController::class, 'update']);
    Route::delete('karyawans/{karyawan}', [KaryawanSwaggerController::class, 'destroy']);
});
