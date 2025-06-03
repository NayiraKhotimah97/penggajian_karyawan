<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembayaran;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="RiwayatPembayaran",
 *     type="object",
 *     required={"id_gaji", "metode_pembayaran", "tanggal_pembayaran", "nominal_pembayaran"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="id_gaji", type="integer", example=1),
 *     @OA\Property(property="metode_pembayaran", type="string", example="Transfer Bank"),
 *     @OA\Property(property="tanggal_pembayaran", type="string", format="date", example="2025-04-29"),
 *     @OA\Property(property="nominal_pembayaran", type="number", example=4500000),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-03T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-03T12:34:56Z")
 * )
 */

class RiwayatPembayaranSwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/riwayat-pembayarans",
     *     tags={"Riwayat Pembayaran"},
     *     summary="List all riwayat pembayaran",
     *     description="Menampilkan daftar semua riwayat pembayaran beserta data gaji",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar riwayat pembayaran",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/RiwayatPembayaran"))
     *     )
     * )
     */
    public function index()
    {
        $riwayatPembayarans = RiwayatPembayaran::with('gaji')->get();
        return response()->json($riwayatPembayarans);
    }

    /**
     * @OA\Post(
     *     path="/riwayat-pembayarans",
     *     tags={"Riwayat Pembayaran"},
     *     summary="Create new riwayat pembayaran",
     *     description="Membuat data riwayat pembayaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_gaji", "metode_pembayaran", "tanggal_pembayaran", "nominal_pembayaran"},
     *             @OA\Property(property="id_gaji", type="integer", example=1),
     *             @OA\Property(property="metode_pembayaran", type="string", example="Transfer Bank"),
     *             @OA\Property(property="tanggal_pembayaran", type="string", format="date", example="2025-04-29"),
     *             @OA\Property(property="nominal_pembayaran", type="number", example=4500000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil membuat riwayat pembayaran",
     *         @OA\JsonContent(ref="#/components/schemas/RiwayatPembayaran")
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/riwayat-pembayarans/{id}",
     *     tags={"Riwayat Pembayaran"},
     *     summary="Show detail riwayat pembayaran",
     *     description="Menampilkan detail riwayat pembayaran berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID riwayat pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail riwayat pembayaran",
     *         @OA\JsonContent(ref="#/components/schemas/RiwayatPembayaran")
     *     )
     * )
     */
    public function show(RiwayatPembayaran $riwayatPembayaran)
    {
        return response()->json($riwayatPembayaran);
    }

    /**
     * @OA\Put(
     *     path="/riwayat-pembayarans/{id}",
     *     tags={"Riwayat Pembayaran"},
     *     summary="Update riwayat pembayaran",
     *     description="Memperbarui data riwayat pembayaran",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID riwayat pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id_gaji", type="integer", example=1),
     *             @OA\Property(property="metode_pembayaran", type="string", example="Tunai"),
     *             @OA\Property(property="tanggal_pembayaran", type="string", format="date", example="2025-04-30"),
     *             @OA\Property(property="nominal_pembayaran", type="number", example=5000000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil memperbarui riwayat pembayaran",
     *         @OA\JsonContent(ref="#/components/schemas/RiwayatPembayaran")
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/riwayat-pembayarans/{id}",
     *     tags={"Riwayat Pembayaran"},
     *     summary="Delete riwayat pembayaran",
     *     description="Menghapus data riwayat pembayaran berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID riwayat pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Berhasil menghapus riwayat pembayaran"
     *     )
     * )
     */
    public function destroy(RiwayatPembayaran $riwayatPembayaran)
    {
        $riwayatPembayaran->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/riwayat-pembayarans/tanggal/{tanggal}",
     *     tags={"Riwayat Pembayaran"},
     *     summary="Ambil riwayat pembayaran berdasarkan tanggal",
     *     @OA\Parameter(
     *         name="tanggal",
     *         in="path",
     *         required=true,
     *         description="Tanggal pembayaran (YYYY-MM-DD)",
     *         @OA\Schema(type="string", example="2025-04-29")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data riwayat pembayaran berdasarkan tanggal",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/RiwayatPembayaran"))
     *     )
     * )
     */
    public function getByTanggal($tanggal)
    {
        $riwayat = RiwayatPembayaran::whereDate('tanggal_pembayaran', $tanggal)->get();
        return response()->json($riwayat);
    }

    /**
     * @OA\Get(
     *     path="/riwayat-pembayarans/by-nominal/{nominal}",
     *     tags={"Riwayat Pembayaran"},
     *     summary="Ambil riwayat pembayaran berdasarkan nominal",
     *     @OA\Parameter(
     *         name="nominal",
     *         in="path",
     *         required=true,
     *         description="Nominal pembayaran",
     *         @OA\Schema(type="number", example=4500000)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data riwayat pembayaran berdasarkan nominal",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/RiwayatPembayaran"))
     *     ),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function getByNominal($nominal)
    {
        $riwayat = RiwayatPembayaran::where('nominal_pembayaran', $nominal)->get();

        if ($riwayat->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($riwayat);
    }
}
