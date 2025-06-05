<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        ]);

        $absensi = Absensi::create([
            'karyawan_id' => $request->karyawan_id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => null,
            'total_jam_kerja' => null,
        ]);

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

    // Memperbarui absensi (isi jam_keluar, hitung total_jam_kerja)
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jam_keluar' => 'required|date_format:H:i',
        ]);

        $jamMasuk = $absensi->jam_masuk;
        $jamKeluar = $request->jam_keluar;

        // Ambil hanya jam dan menit
        if (strlen($jamMasuk) === 8) {
            $jamMasuk = substr($jamMasuk, 0, 5); // dari '08:00:00' jadi '08:00'
        }

        // Cek format jam_masuk
        if (!preg_match('/^\d{2}:\d{2}$/', $jamMasuk)) {
            return response()->json(['message' => 'Format jam_masuk tidak valid: ' . $jamMasuk], 422);
        }

        if (!$jamMasuk) {
            return response()->json(['message' => 'jam_masuk belum diisi pada absensi ini.'], 422);
        }

        $start = Carbon::createFromFormat('H:i', $jamMasuk);
        $end = Carbon::createFromFormat('H:i', $jamKeluar);
        $totalJam = $end->floatDiffInHours($start);

        $absensi->update([
            'jam_keluar' => $jamKeluar,
            'total_jam_kerja' => $totalJam,
        ]);

        return response()->json($absensi);
    }

    // Menghapus absensi
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return response()->json(null, 204);
    }

    // Menampilkan daftar absensi berdasarkan karyawan
    public function getByKaryawan($karyawan_id)
    {
        $absensis = Absensi::where('karyawan_id', $karyawan_id)->get();
        return response()->json($absensis);
    }

    // Menampilkan daftar absensi berdasarkan tanggal
    public function getByTanggal($tanggal)
    {
        $absensis = Absensi::where('tanggal', $tanggal)->get();
        return response()->json($absensis);
    }
}
