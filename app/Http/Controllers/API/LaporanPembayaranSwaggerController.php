<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LaporanPembayaran;
use Illuminate\Http\Request;

class LaporanPembayaranSwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/laporan-pembayarans",
     *     tags={"Laporan Pembayaran"},
     *     summary="List semua laporan pembayaran",
     *     @OA\Response(
     *         response=200,
     *         description="Data laporan pembayaran berhasil ditampilkan",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/LaporanPembayaran"))
     *     )
     * )
     */
    public function index()
    {
        $laporanPembayarans = LaporanPembayaran::all();
        return response()->json($laporanPembayarans);
    }

    /**
     * @OA\Post(
     *     path="/laporan-pembayarans",
     *     tags={"Laporan Pembayaran"},
     *     summary="Buat laporan pembayaran baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"periode_Laporan", "jumlah_karyawan", "total_pengeluaran", "rata_rata"},
     *             @OA\Property(property="periode_Laporan", type="string", format="date", example="2025-04-01"),
     *             @OA\Property(property="jumlah_karyawan", type="string", example="10"),
     *             @OA\Property(property="total_pengeluaran", type="string", example="15000000"),
     *             @OA\Property(property="rata_rata", type="string", example="1500000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berhasil membuat laporan",
     *         @OA\JsonContent(ref="#/components/schemas/LaporanPembayaran")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode_Laporan' => 'required|date',
            'jumlah_karyawan' => 'required|string|max:255',
            'total_pengeluaran' => 'required|string|max:255',
            'rata_rata' => 'required|string|max:255',
        ]);

        $laporanPembayaran = LaporanPembayaran::create($request->all());

        return response()->json($laporanPembayaran, 201);
    }

    /**
     * @OA\Get(
     *     path="/laporan-pembayarans/{laporanPembayaran}",
     *     tags={"Laporan Pembayaran"},
     *     summary="Detail laporan pembayaran",
     *     @OA\Parameter(
     *         name="laporanPembayaran",
     *         in="path",
     *         required=true,
     *         description="ID laporan pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail laporan ditemukan",
     *         @OA\JsonContent(ref="#/components/schemas/LaporanPembayaran")
     *     ),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan")
     * )
     */
    public function show(LaporanPembayaran $laporanPembayaran)
    {
        return response()->json($laporanPembayaran);
    }

    /**
     * @OA\Put(
     *     path="/laporan-pembayarans/{laporanPembayaran}",
     *     tags={"Laporan Pembayaran"},
     *     summary="Update laporan pembayaran",
     *     @OA\Parameter(
     *         name="laporanPembayaran",
     *         in="path",
     *         required=true,
     *         description="ID laporan pembayaran",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="periode_Laporan", type="string", format="date", example="2025-04-01"),
     *             @OA\Property(property="jumlah_karyawan", type="string", example="12"),
     *             @OA\Property(property="total_pengeluaran", type="string", example="18000000"),
     *             @OA\Property(property="rata_rata", type="string", example="1500000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Laporan berhasil diperbarui",
     *         @OA\JsonContent(ref="#/components/schemas/LaporanPembayaran")
     *     )
     * )
     */
    public function update(Request $request, LaporanPembayaran $laporanPembayaran)
    {
        $request->validate([
            'periode_Laporan' => 'sometimes|required|date',
            'jumlah_karyawan' => 'sometimes|required|string|max:255',
            'total_pengeluaran' => 'sometimes|required|string|max:255',
            'rata_rata' => 'sometimes|required|string|max:255',
        ]);

        $laporanPembayaran->update($request->all());

        return response()->json($laporanPembayaran);
    }

    /**
     * @OA\Delete(
     *     path="/laporan-pembayarans/{laporanPembayaran}",
     *     tags={"Laporan Pembayaran"},
     *     summary="Hapus laporan pembayaran",
     *     @OA\Parameter(
     *         name="laporanPembayaran",
     *         in="path",
     *         required=true,
     *         description="ID laporan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Laporan berhasil dihapus"
     *     )
     * )
     */
    public function destroy(LaporanPembayaran $laporanPembayaran)
    {
        $laporanPembayaran->delete();
        return response()->json(null, 204);
    }
}
