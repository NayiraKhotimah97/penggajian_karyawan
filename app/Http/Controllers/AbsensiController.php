<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Menampilkan daftar absensi
    public function index()
    {
        $absensis = Absensi::all();
        return response()->json($absensis);
    }

    // Menampilkan form untuk membuat absensi baru
    public function create()
    {
        // Tidak digunakan dalam API
    }

    // Menyimpan absensi baru
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
            'total_jam_kerja' => 'required|numeric',
        ]);

        $absensi = Absensi::create($request->all());

        return response()->json($absensi, 201);
    }

    // Menampilkan detail absensi
    public function show(Absensi $absensi)
    {
        return response()->json($absensi);
    }

    // Menampilkan form untuk mengedit absensi
    public function edit(Absensi $absensi)
    {
        // Tidak digunakan dalam API
    }

    // Memperbarui absensi
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
            'total_jam_kerja' => 'required|numeric',
        ]);

        $absensi->update($request->all());

        return response()->json($absensi);
    }

    // Menghapus absensi
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return response()->json(null, 204);
    }
}