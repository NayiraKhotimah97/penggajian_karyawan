<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
    {
        $karyawans = Karyawan::all();
        return response()->json($karyawans);
    }

    // Menyimpan karyawan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|unique:karyawans,gaji_pokok',
            'email' => 'required|email|unique:karyawans,email',
        ]);

        $karyawan = Karyawan::create($request->all());

        return response()->json($karyawan, 201);
    }

    // Menampilkan detail karyawan
    public function show(Karyawan $karyawan)
    {
        return response()->json($karyawan);
    }

    // Memperbarui karyawan
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'jabatan' => 'sometimes|required|string|max:255',
            'gaji_pokok' => 'sometimes|required|numeric|unique:karyawans,gaji_pokok,' . $karyawan->id,
            'email' => 'sometimes|required|email|unique:karyawans,email,' . $karyawan->id,
        ]);

        $karyawan->update($request->all());

        return response()->json($karyawan);
    }

    // Menghapus karyawan
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return response()->json(null, 204);
    }
}