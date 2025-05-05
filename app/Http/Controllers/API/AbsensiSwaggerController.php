<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Absensi",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="karyawan_id", type="integer"),
 *         @OA\Property(property="tanggal", type="string", format="date"),
 *         @OA\Property(property="jam_masuk", type="string", format="time"),
 *         @OA\Property(property="jam_keluar", type="string", format="time"),
 *         @OA\Property(property="total_jam_kerja", type="number", format="float")
 *     }
 * )
 */

class AbsensiSwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/absensis",
     *     tags={"Absensi"},
     *     summary="List all absensi",
     *     description="Menampilkan daftar semua absensi",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data absensi",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Absensi"))
     *     )
     * )
     */
    public function index()
    {
        // Ambil semua data absensi dari database
        $absensis = Absensi::all();
        return response()->json($absensis);
    }

    /**
     * @OA\Post(
     *     path="/absensis",
     *     tags={"Absensi"},
     *     summary="Create new absensi",
     *     description="Membuat data absensi baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"karyawan_id", "tanggal", "jam_masuk", "jam_keluar", "total_jam_kerja"},
     *             @OA\Property(property="karyawan_id", type="integer", example=2),
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-04-28"),
     *             @OA\Property(property="jam_masuk", type="string", format="time", example="08:00"),
     *             @OA\Property(property="jam_keluar", type="string", format="time", example="17:00"),
     *             @OA\Property(property="total_jam_kerja", type="number", example=8)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil membuat absensi baru",
     *         @OA\JsonContent(ref="#/components/schemas/Absensi")
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
            'total_jam_kerja' => 'required|numeric',
        ]);

        // Menyimpan data absensi baru
        $absensi = Absensi::create($request->all());

        return response()->json($absensi, 201);
    }

    /**
     * @OA\Get(
     *     path="/absensis/{absensi}",
     *     tags={"Absensi"},
     *     summary="Show a specific absensi",
     *     description="Menampilkan detail absensi berdasarkan ID",
     *     @OA\Parameter(
     *         name="absensi",
     *         in="path",
     *         required=true,
     *         description="ID absensi",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail data absensi",
     *         @OA\JsonContent(ref="#/components/schemas/Absensi")
     *     ),
     *     @OA\Response(response=404, description="Absensi not found")
     * )
     */
    public function show(Absensi $absensi)
    {
        return response()->json($absensi);
    }

    /**
     * @OA\Put(
     *     path="/absensis/{absensi}",
     *     tags={"Absensi"},
     *     summary="Update a specific absensi",
     *     description="Memperbarui data absensi berdasarkan ID",
     *     @OA\Parameter(
     *         name="absensi",
     *         in="path",
     *         required=true,
     *         description="ID absensi",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"karyawan_id", "tanggal", "jam_masuk", "jam_keluar", "total_jam_kerja"},
     *             @OA\Property(property="karyawan_id", type="integer", example=2),
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-04-28"),
     *             @OA\Property(property="jam_masuk", type="string", format="time", example="08:00"),
     *             @OA\Property(property="jam_keluar", type="string", format="time", example="17:00"),
     *             @OA\Property(property="total_jam_kerja", type="number", example=8)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil memperbarui absensi",
     *         @OA\JsonContent(ref="#/components/schemas/Absensi")
     *     )
     * )
     */
    public function update(Request $request, Absensi $absensi)
    {
        // Validasi data yang diterima
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
            'total_jam_kerja' => 'required|numeric',
        ]);

        // Update data absensi
        $absensi->update($request->all());

        return response()->json($absensi);
    }

    /**
     * @OA\Delete(
     *     path="/absensis/{absensi}",
     *     tags={"Absensi"},
     *     summary="Delete a specific absensi",
     *     description="Menghapus data absensi berdasarkan ID",
     *     @OA\Parameter(
     *         name="absensi",
     *         in="path",
     *         required=true,
     *         description="ID absensi",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Berhasil menghapus absensi"
     *     )
     * )
     */
    public function destroy(Absensi $absensi)
    {
        // Hapus data absensi
        $absensi->delete();
        return response()->json(null, 204);
    }
}
