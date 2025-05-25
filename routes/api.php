<?php

use App\Http\Controllers\API\AbsensiSwaggerController;
use App\Http\Controllers\API\CategorySwaggerController;
use App\Http\Controllers\API\GajiSwaggerController;
use App\Http\Controllers\API\KaryawanSwaggerController;
use App\Http\Controllers\API\LaporanPembayaranSwaggerController;
use App\Http\Controllers\API\RiwayatPembayaranSwaggerController;
use App\Http\Controllers\API\DepartemenSwaggerController;
use App\Http\Controllers\DepartemenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\RiwayatPembayaranController;
use App\Http\Controllers\LaporanPembayaranController;

Route::group([], function () {
    Route::get('laporan-pembayarans', [LaporanPembayaranController::class, 'index']);
    Route::post('laporan-pembayarans', [LaporanPembayaranController::class, 'store']);
    Route::get('laporan-pembayarans/{id}', [LaporanPembayaranController::class, 'show']);
    Route::put('laporan-pembayarans/{id}', [LaporanPembayaranController::class, 'update']);
    Route::delete('laporan-pembayarans/{id}', [LaporanPembayaranController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('riwayat-pembayarans', [RiwayatPembayaranController::class, 'index']);
    Route::post('riwayat-pembayarans', [RiwayatPembayaranController::class, 'store']);
    Route::get('riwayat-pembayarans/{riwayat_pembayaran}', [RiwayatPembayaranController::class, 'show']);
    Route::put('riwayat-pembayarans/{riwayat_pembayaran}', [RiwayatPembayaranController::class, 'update']);
    Route::delete('riwayat-pembayarans/{riwayat_pembayaran}', [RiwayatPembayaranController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('gajis', [GajiController::class, 'index']);
    Route::post('gajis', [GajiController::class, 'store']);
    Route::get('gajis/{id}', [GajiController::class, 'show']);
    Route::put('gajis/{id}', [GajiController::class, 'update']);
    Route::delete('gajis/{id}', [GajiController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('karyawans', [KaryawanController::class, 'index']);
    Route::post('karyawans', [KaryawanController::class, 'store']);
    Route::get('karyawans/{karyawan}', [KaryawanController::class, 'show']);
    Route::put('karyawans/{karyawan}', [KaryawanController::class, 'update']);
    Route::delete('karyawans/{karyawan}', [KaryawanController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('absensis', [AbsensiController::class, 'index']);
    Route::post('absensis', [AbsensiController::class, 'store']);
    Route::get('absensis/{absensi}', [AbsensiController::class, 'show']);
    Route::put('absensis/{absensi}', [AbsensiController::class, 'update']);
    Route::delete('absensis/{absensi}', [AbsensiController::class, 'destroy']);
});


Route::group([], function () {
    Route::get('departemen', [DepartemenController::class, 'index']);
    Route::post('departemen', [DepartemenController::class, 'store']);
    Route::get('departemen/{id}', [DepartemenController::class, 'show']);
    Route::put('departemen/{id}', [DepartemenController::class, 'update']);
    Route::delete('departemen/{id}', [DepartemenController::class, 'destroy']);
});




// SWAGGER CONTROLLER ROUTE
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

Route::apiResource('laporan-pembayarans', LaporanPembayaranSwaggerController::class);

Route::group([], function () {
    Route::get('riwayat-pembayarans', [RiwayatPembayaranSwaggerController::class, 'index']);
    Route::post('riwayat-pembayarans', [RiwayatPembayaranSwaggerController::class, 'store']);
    Route::get('riwayat-pembayarans/{id}', [RiwayatPembayaranSwaggerController::class, 'show']);
    Route::put('riwayat-pembayarans/{id}', [RiwayatPembayaranSwaggerController::class, 'update']);
    Route::delete('riwayat-pembayarans/{id}', [RiwayatPembayaranSwaggerController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('departemens', [DepartemenSwaggerController::class, 'index']);
    Route::post('departemens', [DepartemenSwaggerController::class, 'store']);
    Route::get('departemens/{id}', [DepartemenSwaggerController::class, 'show']);
    Route::put('departemens/{id}', [DepartemenSwaggerController::class, 'update']);
    Route::delete('departemens/{id}', [DepartemenSwaggerController::class, 'destroy']);
});
