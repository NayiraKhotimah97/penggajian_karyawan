<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanSwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/karyawans",
     *     tags={"Karyawan"},
     *     summary="List all karyawan",
     *     description="Menampilkan daftar semua karyawan",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data karyawan",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Karyawan"))
     *     )
     * )
     */
    public function index()
    {
        $karyawans = Karyawan::all();
        return response()->json($karyawans);
    }

    /**
     * @OA\Post(
     *     path="/karyawans",
     *     tags={"Karyawan"},
     *     summary="Create new karyawan",
     *     description="Membuat data karyawan baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "jabatan", "gaji_pokok", "email"},
     *             @OA\Property(property="nama", type="string", example="John Doe"),
     *             @OA\Property(property="jabatan", type="string", example="Manager"),
     *             @OA\Property(property="gaji_pokok", type="number", example=5000000),
     *             @OA\Property(property="email", type="string", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil membuat karyawan baru",
     *         @OA\JsonContent(ref="#/components/schemas/Karyawan")
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/karyawans/{karyawan}",
     *     tags={"Karyawan"},
     *     summary="Show a specific karyawan",
     *     description="Menampilkan detail karyawan berdasarkan ID",
     *     @OA\Parameter(
     *         name="karyawan",
     *         in="path",
     *         required=true,
     *         description="ID karyawan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail data karyawan",
     *         @OA\JsonContent(ref="#/components/schemas/Karyawan")
     *     ),
     *     @OA\Response(response=404, description="Karyawan not found")
     * )
     */
    public function show(Karyawan $karyawan)
    {
        return response()->json($karyawan);
    }

    /**
     * @OA\Put(
     *     path="/karyawans/{karyawan}",
     *     tags={"Karyawan"},
     *     summary="Update a specific karyawan",
     *     description="Memperbarui data karyawan berdasarkan ID",
     *     @OA\Parameter(
     *         name="karyawan",
     *         in="path",
     *         required=true,
     *         description="ID karyawan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "jabatan", "gaji_pokok", "email"},
     *             @OA\Property(property="nama", type="string", example="John Doe"),
     *             @OA\Property(property="jabatan", type="string", example="Manager"),
     *             @OA\Property(property="gaji_pokok", type="number", example=5000000),
     *             @OA\Property(property="email", type="string", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil memperbarui karyawan",
     *         @OA\JsonContent(ref="#/components/schemas/Karyawan")
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/karyawans/{karyawan}",
     *     tags={"Karyawan"},
     *     summary="Delete a specific karyawan",
     *     description="Menghapus data karyawan berdasarkan ID",
     *     @OA\Parameter(
     *         name="karyawan",
     *         in="path",
     *         required=true,
     *         description="ID karyawan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Berhasil menghapus karyawan"
     *     )
     * )
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return response()->json(null, 204);
    }
}
