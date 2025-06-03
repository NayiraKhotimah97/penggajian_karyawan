<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Karyawan",
 *     type="object",
 *     required={"nama", "jabatan", "gaji_pokok", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama", type="string", example="John Doe"),
 *     @OA\Property(property="jabatan", type="string", example="Manager"),
 *     @OA\Property(property="gaji_pokok", type="number", format="float", example=5000000),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-03T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-03T12:34:56Z")
 * )
 */

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
            'departemen_id' => 'required|exists:departemens,id',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|unique:karyawans,gaji_pokok',
            'email' => 'required|email|unique:karyawans,email',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
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
            'departemen_id' => 'sometimes|required|exists:departemens,id',
            'nama' => 'sometimes|required|string|max:255',
            'jabatan' => 'sometimes|required|string|max:255',
            'gaji_pokok' => 'sometimes|required|numeric|unique:karyawans,gaji_pokok,' . $karyawan->id,
            'email' => 'sometimes|required|email|unique:karyawans,email,' . $karyawan->id,
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
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

    /**
     * @OA\Get(
     *     path="/karyawans/departemen/{departemen_id}",
     *     tags={"Karyawan"},
     *     summary="Get karyawan by departemen",
     *     description="Menampilkan daftar karyawan berdasarkan ID departemen",
     *     @OA\Parameter(
     *         name="departemen_id",
     *         in="path",
     *         required=true,
     *         description="ID departemen",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data karyawan berdasarkan departemen",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Karyawan"))
     *     ),
     *     @OA\Response(response=404, description="Departemen not found")
     * )
     */
    public function getByDepartemen($departemen_id)
    {
        $karyawans = Karyawan::where('departemen_id', $departemen_id)->get();
        return response()->json($karyawans);
    }

    /**
     * @OA\Get(
     *     path="/karyawans/search/{nama}",
     *     tags={"Karyawan"},
     *     summary="Search karyawan by name",
     *     description="Mencari karyawan berdasarkan nama",
     *     @OA\Parameter(
     *         name="nama",
     *         in="path",
     *         required=true,
     *         description="Nama karyawan",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil menemukan karyawan",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Karyawan"))
     *     ),
     *     @OA\Response(response=404, description="Karyawan not found")
     * )
     */
    public function searchByName($nama)
    {
        $karyawans = Karyawan::where('nama', 'like', '%' . $nama . '%')->get();
        return response()->json($karyawans);
    }
}
