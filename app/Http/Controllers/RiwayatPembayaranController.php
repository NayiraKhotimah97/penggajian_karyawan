<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPembayaran;
use Illuminate\Http\Request;

class RiwayatPembayaranController extends Controller
{
    // Menampilkan daftar riwayat pembayaran
    public function index()
    {
        $riwayatPembayarans = RiwayatPembayaran::with('gaji')->get(); // Mengambil data riwayat pembayaran beserta data gaji
        return response()->json($riwayatPembayarans);
    }

    // Menyimpan riwayat pembayaran baru
    public function store(Request $request)
    {
        $request->validate([
            'id_gaji' => 'required|exists:gajis,id',
            'metode_pembayaran' => 'required|string|max:255',
            'tanggal_pembayaran' => 'required|date',
            'nominal_pembayaran' => 'required|numeric',
        ]);

        $riwayatPembayaran = RiwayatPembayaran::create($request->all());

        return response()->json($riwayatPembayaran, 201);
    }

    // Menampilkan detail riwayat pembayaran
    public function show(RiwayatPembayaran $riwayatPembayaran)
    {
        return response()->json($riwayatPembayaran);
    }

    // Memperbarui riwayat pembayaran
    public function update(Request $request, RiwayatPembayaran $riwayatPembayaran)
    {
        $request->validate([
            'id_gaji' => 'sometimes|required|exists:gajis,id',
            'metode_pembayaran' => 'sometimes|required|string|max:255',
            'tanggal_pembayaran' => 'sometimes|required|date',
            'nominal_pembayaran' => 'sometimes|required|numeric',
        ]);

        $riwayatPembayaran->update($request->all());

        return response()->json($riwayatPembayaran);
    }

    // Menghapus riwayat pembayaran
    public function destroy(RiwayatPembayaran $riwayatPembayaran)
    {
        $riwayatPembayaran->delete();
        return response()->json(null, 204);
    }
}