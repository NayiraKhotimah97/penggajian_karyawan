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
            'periode_laporan' => 'required|date',
            'jumlah_karyawan' => 'required|string|max:255',
            'total_pengeluaran' => 'required|string|max:255',
            'rata_rata' => 'required|string|max:255',
        ]);

        $laporanPembayaran = LaporanPembayaran::create($request->all());

        return response()->json($laporanPembayaran, 201);
    }

    // Menampilkan detail laporan pembayaran
    public function show($id)
    {
        $laporanPembayaran = LaporanPembayaran::find($id);

        if (!$laporanPembayaran) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Laporan tidak ditemukan.'
            ], 404);
        }

        return response()->json($laporanPembayaran);
    }

    // Memperbarui laporan pembayaran
    public function update(Request $request, LaporanPembayaran $laporanPembayaran)
    {
        $request->validate([
            'periode_laporan' => 'sometimes|required|date',
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
    public function getByPeriode($periode)
    {
        // Validasi manual format Y-m (contoh: 2025-06)
        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) {
            return response()->json(['error' => 'Format periode tidak valid (Y-m)'], 422);
        }

        $laporan = LaporanPembayaran::whereRaw("DATE_FORMAT(periode_Laporan, '%Y-%m') = ?", [$periode])->get();

        return response()->json($laporan);
    }


    // Menghitung total pengeluaran dari semua laporan pembayaran
    public function getTotalPengeluaran($total)
    {
        $laporan = LaporanPembayaran::where('total_pengeluaran', $total)->get();

        return response()->json($laporan);
    }

}
