<?php

namespace App\Http\Controllers;

use App\Models\LaporanPembayaran;
use Illuminate\Http\Request;

class LaporanPembayaranController extends Controller
{
    // Menampilkan daftar laporan pembayaran
    public function index()
    {
        $laporanPembayarans = LaporanPembayaran::all();
        return response()->json($laporanPembayarans);
    }

    // Menyimpan laporan pembayaran baru
    public function store(Request $request)
    {
        $request->validate([
            'periode_Laporan' => 'required|date',
            'jumlah_karyawan' => 'required|string|max:255',
            'total_pengeluaran' => 'required|string|max:255',
            'rata_rata' => 'required|string|max:255',
        ]);

        $laporanPembayaran = LaporanPembayaran::create($request->all());

        return response()->json($laporanPembayaran, 201);
    }

    // Menampilkan detail laporan pembayaran
    public function show(LaporanPembayaran $laporanPembayaran)
    {
        return response()->json($laporanPembayaran);
    }

    // Memperbarui laporan pembayaran
    public function update(Request $request, LaporanPembayaran $laporanPembayaran)
    {
        $request->validate([
            'periode_Laporan' => 'sometimes|required|date',
            'jumlah_karyawan' => 'sometimes|required|string|max:255',
            'total_pengeluaran' => 'sometimes|required|string|max:255',
            'rata_rata' => 'sometimes|required|string|max:255',
        ]);

        $laporanPembayaran->update($request->all());

        return response()->json($laporanPembayaran);
    }

    // Menghapus laporan pembayaran
    public function destroy(LaporanPembayaran $laporanPembayaran)
    {
        $laporanPembayaran->delete();
        return response()->json(null, 204);
    }

    // Menampilkan laporan berdasarkan periode (YYYY-MM)
    public function getByPeriode(Request $request)
    {
        $request->validate([
            'periode' => 'required|date_format:Y-m', // Contoh: 2025-06
        ]);

        $periode = $request->input('periode');

        $laporan = LaporanPembayaran::whereRaw("DATE_FORMAT(periode_Laporan, '%Y-%m') = ?", [$periode])->get();

        return response()->json($laporan);
    }

    // Menghitung total pengeluaran dari semua laporan pembayaran
    public function getTotalPengeluaran()
    {
        $totalPengeluaran = LaporanPembayaran::sum('total_pengeluaran');

        return response()->json([
            'total_pengeluaran' => $totalPengeluaran
        ]);
    }
}
