<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Gaji",
 *     type="object",
 *     required={"karyawan_id", "periode_gaji", "gaji_pokok", "total_jam_kerja", "bonus", "potongan", "total_gaji"},
 *     @OA\Property(property="id", type="integer", description="ID Gaji", example=1),
 *     @OA\Property(property="karyawan_id", type="integer", description="ID Karyawan", example=2),
 *     @OA\Property(property="periode_gaji", type="string", format="date", description="Periode Gaji", example="2025-04-28"),
 *     @OA\Property(property="gaji_pokok", type="number", format="float", description="Gaji Pokok", example=5000000),
 *     @OA\Property(property="total-jam-kerja", type="number", format="float", description="Total Jam Kerja", example=160),
 *     @OA\Property(property="bonus", type="number", format="float", description="Bonus", example=500000),
 *     @OA\Property(property="potongan", type="number", format="float", description="Potongan", example=200000),
 *     @OA\Property(property="total_gaji", type="number", format="float", description="Total Gaji", example=5300000),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Waktu Dibuat", example="2025-04-28T08:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Waktu Diperbarui", example="2025-04-28T09:00:00Z")
 * )
 */

class GajiSwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/gajis",
     *     tags={"Gaji"},
     *     summary="List all gaji",
     *     description="Menampilkan daftar semua data gaji beserta karyawan",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data gaji",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Gaji"))
     *     )
     * )
     */
    public function index()
    {
        $gajis = Gaji::with('karyawan')->get();
        return response()->json($gajis);
    }

    /**
     * @OA\Post(
     *     path="/gajis",
     *     tags={"Gaji"},
     *     summary="Create new gaji",
     *     description="Membuat data gaji baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"karyawan_id", "periode_gaji", "gaji_pokok", "total_jam_kerja", "bonus", "potongan", "total_gaji"},
     *             @OA\Property(property="karyawan_id", type="integer", example=1),
     *             @OA\Property(property="periode_gaji", type="string", format="date", example="2025-04-28"),
     *             @OA\Property(property="gaji_pokok", type="number", format="float", example=5000000),
     *             @OA\Property(property="total-jam-kerja", type="number", format="float", example=160),
     *             @OA\Property(property="bonus", type="number", format="float", example=500000),
     *             @OA\Property(property="potongan", type="number", format="float", example=200000),
     *             @OA\Property(property="total_gaji", type="number", format="float", example=5300000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil membuat data gaji",
     *         @OA\JsonContent(ref="#/components/schemas/Gaji")
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/gajis/{id}",
     *     tags={"Gaji"},
     *     summary="Show specific gaji",
     *     description="Menampilkan detail data gaji berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID data gaji",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail data gaji",
     *         @OA\JsonContent(ref="#/components/schemas/Gaji")
     *     ),
     *     @OA\Response(response=404, description="Gaji not found")
     * )
     */
    public function show(Gaji $gaji)
    {
        return response()->json($gaji);
    }

    /**
     * @OA\Put(
     *     path="/gajis/{id}",
     *     tags={"Gaji"},
     *     summary="Update specific gaji",
     *     description="Memperbarui data gaji berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID data gaji",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="karyawan_id", type="integer", example=1),
     *             @OA\Property(property="periode_gaji", type="string", format="date", example="2025-04-28"),
     *             @OA\Property(property="gaji_pokok", type="number", format="float", example=5500000),
     *             @OA\Property(property="total-jam-kerja", type="number", format="float", example=170),
     *             @OA\Property(property="bonus", type="number", format="float", example=600000),
     *             @OA\Property(property="potongan", type="number", format="float", example=100000),
     *             @OA\Property(property="total_gaji", type="number", format="float", example=6000000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil memperbarui data gaji",
     *         @OA\JsonContent(ref="#/components/schemas/Gaji")
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/gajis/{id}",
     *     tags={"Gaji"},
     *     summary="Delete specific gaji",
     *     description="Menghapus data gaji berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID data gaji",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Berhasil menghapus data gaji"
     *     )
     * )
     */
    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/gajis/karyawan/{karyawan_id}",
     *     tags={"Gaji"},
     *     summary="List gaji berdasarkan karyawan",
     *     description="Menampilkan daftar gaji berdasarkan ID karyawan",
     *     @OA\Parameter(
     *         name="karyawan_id",
     *         in="path",
     *         required=true,
     *         description="ID karyawan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data gaji berdasarkan karyawan",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Gaji"))
     *     )
     * )
     */
    public function getByKaryawan($karyawan_id)
    {
        $gajis = Gaji::where('karyawan_id', $karyawan_id)->with('karyawan')->get();
        return response()->json($gajis);
    }
}
