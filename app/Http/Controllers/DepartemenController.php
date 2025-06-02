<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    // Menampilkan daftar departemen
    public function index()
{
    $departemens = Departemen::all();
    return response()->json($departemens);
}


    // Menyimpan departemen baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'kepala_departemen' => 'required|string|max:255',
            'jumlah_karyawan' => 'required|numeric|unique:departemens,jumlah_karyawan',
            'keterangan' => 'required|string|max:255',
        ]);

        $departemen = Departemen::create($request->all());

        return response()->json($departemen, 201);
    }

    // Menampilkan detail departemen
    public function show(Departemen $departemen)
    {
        return response()->json($departemen);
    }

    // Memperbarui karyawan
    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'nama_departemen' => 'sometimes|required|string|max:255',
            'kepala_departemen' => 'sometimes|required|string|max:255',
            'jumlah_karyawan' => 'sometimes|required|numeric|unique:departemen,jumlah_karyawan,' . $departemen->id,
            'keterangan' => 'sometimes|required|string|max:255',
        ]);

        $departemen->update($request->all());

        return response()->json($departemen);
    }

    // Menghapus karyawan
    public function destroy(Departemen $departemen)
    {
        $departemen->delete();
        return response()->json(null, 204);
    }

    //menampilkan data lengkap 1 departemen dan karyawannya
    public function getKaryawanByDepartemen($id)
    {
    $departemen = Departemen::with('karyawans')->find($id);
    return response()->json($departemen);
    }
}
