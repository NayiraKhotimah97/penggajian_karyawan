<?php

use App\Http\Controllers\API\CategorySwaggerController;
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
