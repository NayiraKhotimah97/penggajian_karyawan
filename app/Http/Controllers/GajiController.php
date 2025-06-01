<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    // Menampilkan daftar gaji
    public function index()
    {
        $gajis = Gaji::with('karyawan')->get(); // Mengambil data gaji beserta data karyawan
        return response()->json($gajis);
    }

    // Menyimpan gaji baru
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'periode_gaji' => 'required|date',
            'gaji_pokok' => 'required|numeric',
            'total-jam-kerja' => 'required|numeric',
            'bonus' => 'required|numeric',
            'potongan' => 'required|numeric',
            'total_gaji' => 'required|numeric',
        ]);

        $gaji = Gaji::create($request->all());

        return response()->json($gaji, 201);
    }

    // Menampilkan detail gaji
    public function show(Gaji $gaji)
    {
        return response()->json($gaji);
    }

    // Memperbarui gaji
    public function update(Request $request, Gaji $gaji)
    {
        $request->validate([
            'karyawan_id' => 'sometimes|required|exists:karyawans,id',
            'periode_gaji' => 'sometimes|required|date',
            'gaji_pokok' => 'sometimes|required|numeric',
            'total-jam-kerja' => 'sometimes|required|numeric',
            'bonus' => 'sometimes|required|numeric',
            'potongan' => 'sometimes|required|numeric',
            'total_gaji' => 'sometimes|required|numeric',
        ]);

        $gaji->update($request->all());

        return response()->json($gaji);
    }

    // Menghapus gaji
    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return response()->json(null, 204);
    }

    // Menampilkan daftar gaji berdasarkan karyawan
    public function getByKaryawan($karyawan_id)
    {
        $gajis = Gaji::where('karyawan_id', $karyawan_id)->with('karyawan')->get();
        return response()->json($gajis);
    }

    // Menampilkan daftar gaji berdasarkan periode (bulan-tahun)
    public function getByPeriode(Request $request)
    {
        $request->validate([
            'periode' => 'required|date_format:Y-m', // Format periode: YYYY-MM
        ]);

        $periode = $request->input('periode');

        $gajis = Gaji::whereRaw("DATE_FORMAT(periode_gaji, '%Y-%m') = ?", [$periode])->with('karyawan')->get();

        return response()->json($gajis);
    }
}
