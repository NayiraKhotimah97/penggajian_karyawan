<?php

use App\Http\Controllers\API\AbsensiSwaggerController;
use App\Http\Controllers\API\CategorySwaggerController;
use App\Http\Controllers\API\GajiSwaggerController;
use App\Http\Controllers\API\KaryawanSwaggerController;
use App\Http\Controllers\API\LaporanPembayaranSwaggerController;
use App\Http\Controllers\API\RiwayatPembayaranSwaggerController;
use App\Http\Controllers\API\DepartemenSwaggerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
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
    Route::get('laporan-pembayarans/{laporanPembayaran}', [LaporanPembayaranController::class, 'show']);
    Route::put('laporan-pembayarans/{laporanPembayaran}', [LaporanPembayaranController::class, 'update']);
    Route::delete('laporan-pembayarans/{laporanPembayaran}', [LaporanPembayaranController::class, 'destroy']);
    Route::get('/laporan-pembayarans/periode/{periode}', [LaporanPembayaranController::class, 'getByPeriode']);
    Route::get('/laporan-pembayarans/total-pengeluaran/{total}', [LaporanPembayaranController::class, 'getTotalPengeluaran']);
});

Route::group([], function () {
    Route::get('riwayat-pembayarans', [RiwayatPembayaranController::class, 'index']);
    Route::post('riwayat-pembayarans', [RiwayatPembayaranController::class, 'store']);
    Route::get('riwayat-pembayarans/{riwayat_pembayaran}', [RiwayatPembayaranController::class, 'show']);
    Route::put('riwayat-pembayarans/{riwayat_pembayaran}', [RiwayatPembayaranController::class, 'update']);
    Route::delete('riwayat-pembayarans/{riwayat_pembayaran}', [RiwayatPembayaranController::class, 'destroy']);
    Route::get('/riwayat-pembayarans/tanggal/{tanggal}', [RiwayatPembayaranController::class, 'getByTanggal']);
    Route::get('/riwayat-pembayarans/by-nominal/{nominal}', [RiwayatPembayaranController::class, 'getByNominal']);
});

Route::group([], function () {
    Route::get('gajis', [GajiController::class, 'index']);
    Route::post('gajis', [GajiController::class, 'store']);
    Route::get('gajis/{gaji}', [GajiController::class, 'show']);
    Route::put('gajis/{gaji}', [GajiController::class, 'update']);
    Route::delete('gajis/{gaji}', [GajiController::class, 'destroy']);
    Route::get('/gajis/karyawan/{karyawan_id}', [GajiController::class, 'getByKaryawan']);
});

Route::group([], function () {
    Route::get('karyawans', [KaryawanController::class, 'index']);
    Route::post('karyawans', [KaryawanController::class, 'store']);
    Route::get('karyawans/{karyawan}', [KaryawanController::class, 'show']);
    Route::put('karyawans/{karyawan}', [KaryawanController::class, 'update']);
    Route::delete('karyawans/{karyawan}', [KaryawanController::class, 'destroy']);
    Route::get('/karyawans/departemen/{departemen_id}', [KaryawanController::class, 'getByDepartemen']);
    Route::get('/karyawans/search/{nama}', [KaryawanController::class, 'searchByName']);
});

Route::group([], function () {
    Route::get('absensis', [AbsensiController::class, 'index']);
    Route::post('absensis', [AbsensiController::class, 'store']);
    Route::get('absensis/{absensi}', [AbsensiController::class, 'show']);
    Route::put('absensis/{absensi}', [AbsensiController::class, 'update']);
    Route::delete('absensis/{absensi}', [AbsensiController::class, 'destroy']);
    Route::get('/absensis/karyawan/{karyawan_id}', [AbsensiController::class, 'getByKaryawan']);
    Route::get('/absensis/tanggal/{tanggal}', [AbsensiController::class, 'getByTanggal']);
});


Route::group([], function () {
    Route::get('departemen', [DepartemenController::class, 'index']);
    Route::post('departemen', [DepartemenController::class, 'store']);
    Route::get('departemen/{departemen}', [DepartemenController::class, 'show']);
    Route::put('departemen/{departemen}', [DepartemenController::class, 'update']);
    Route::delete('departemen/{departemen}', [DepartemenController::class, 'destroy']);
    Route::get('/departemen/{id}/karyawan', [DepartemenController::class, 'getKaryawanByDepartemen']);
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
    Route::get('/absensis/karyawan/{karyawan_id}', [AbsensiSwaggerController::class, 'getByKaryawan']);
    Route::get('/absensis/tanggal/{tanggal}', [AbsensiSwaggerController::class, 'getByTanggal']);
});

Route::group([], function () {
    Route::get('gajis', [GajiSwaggerController::class, 'index']);
    Route::post('gajis', [GajiSwaggerController::class, 'store']);
    Route::get('gajis/{gaji}', [GajiSwaggerController::class, 'show']);
    Route::put('gajis/{gaji}', [GajiSwaggerController::class, 'update']);
    Route::delete('gajis/{gaji}', [GajiSwaggerController::class, 'destroy']);
    Route::get('gajis/karyawan/{karyawan_id}', [GajiSwaggerController::class, 'getByKaryawan']); // Tambahkan ini
});

Route::group([], function () {
    Route::get('karyawans', [KaryawanSwaggerController::class, 'index']);
    Route::post('karyawans', [KaryawanSwaggerController::class, 'store']);
    Route::get('karyawans/{karyawan}', [KaryawanSwaggerController::class, 'show']);
    Route::put('karyawans/{karyawan}', [KaryawanSwaggerController::class, 'update']);
    Route::delete('karyawans/{karyawan}', [KaryawanSwaggerController::class, 'destroy']);
});

Route::apiResource('laporan-pembayaran', LaporanPembayaranSwaggerController::class);

Route::group([], function () {
    Route::get('riwayat-pembayarans', [RiwayatPembayaranSwaggerController::class, 'index']);
    Route::post('riwayat-pembayarans', [RiwayatPembayaranSwaggerController::class, 'store']);
    Route::get('riwayat-pembayarans/{id}', [RiwayatPembayaranSwaggerController::class, 'show']);
    Route::put('riwayat-pembayarans/{id}', [RiwayatPembayaranSwaggerController::class, 'update']);
    Route::delete('riwayat-pembayarans/{id}', [RiwayatPembayaranSwaggerController::class, 'destroy']);
});

Route::group([], function () {
    Route::get('departemen-swagger', [DepartemenSwaggerController::class, 'index']);
    Route::post('departemen-swagger', [DepartemenSwaggerController::class, 'store']);
    Route::get('departemen-swagger/{id}', [DepartemenSwaggerController::class, 'show']);
    Route::put('departemen-swagger/{id}', [DepartemenSwaggerController::class, 'update']);
    Route::delete('departemen-swagger/{id}', [DepartemenSwaggerController::class, 'destroy']);
    Route::get('departemen-swagger/{id}/karyawan', [DepartemenSwaggerController::class, 'getKaryawanByDepartemen']);
});


// Auth
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Register
Route::post('/register', RegisterController::class);

// Login
Route::post('/login', LoginController::class);

// Logout
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
