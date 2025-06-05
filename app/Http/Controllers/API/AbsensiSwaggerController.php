<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data absensi",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Absensi"))
     *     )
     * )
     */
    public function index()
    {
        $absensis = Absensi::all();
        return response()->json($absensis);
    }

    /**
     * @OA\Post(
     *     path="/absensis",
     *     tags={"Absensi"},
     *     summary="Create new absensi",
     *     description="Membuat data absensi baru (hanya karyawan_id, tanggal, jam_masuk)",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"karyawan_id", "tanggal", "jam_masuk"},
     *             @OA\Property(property="karyawan_id", type="integer", example=2),
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-04-28"),
     *             @OA\Property(property="jam_masuk", type="string", format="time", example="08:00")
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

    /**
     * @OA\Get(
     *     path="/absensis/{absensi}",
     *     tags={"Absensi"},
     *     summary="Show a specific absensi",
     *     description="Menampilkan detail absensi berdasarkan ID",
     *     security={{"bearerAuth":{}}},
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
     *     summary="Update jam_keluar dan hitung total_jam_kerja",
     *     description="Update absensi untuk pulang kerja, otomatis hitung total_jam_kerja dari jam_masuk dan jam_keluar",
     *     security={{"bearerAuth":{}}},
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
     *             required={"karyawan_id", "jam_keluar"},
     *             @OA\Property(property="karyawan_id", type="integer", example=2),
     *             @OA\Property(property="jam_keluar", type="string", format="time", example="17:00")
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
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jam_keluar' => 'required|date_format:H:i',
        ]);

        $jamMasuk = $absensi->jam_masuk;
        $jamKeluar = $request->jam_keluar;

        // Ambil hanya jam dan menit jika format '08:00:00'
        if (strlen($jamMasuk) === 8) {
            $jamMasuk = substr($jamMasuk, 0, 5);
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

        // Validasi agar total jam kerja tidak minus
        if ($end->lessThan($start)) {
            return response()->json(['message' => 'jam_keluar tidak boleh lebih awal dari jam_masuk.'], 422);
        }

        $totalJam = $end->floatDiffInHours($start);

        $absensi->update([
            'jam_keluar' => $jamKeluar,
            'total_jam_kerja' => $totalJam,
        ]);

        return response()->json($absensi);
    }

    /**
     * @OA\Delete(
     *     path="/absensis/{absensi}",
     *     tags={"Absensi"},
     *     summary="Delete a specific absensi",
     *     description="Menghapus data absensi berdasarkan ID",
     *     security={{"bearerAuth":{}}},
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
        $absensi->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/absensis/karyawan/{karyawan_id}",
     *     tags={"Absensi"},
     *     summary="List absensi by karyawan",
     *     description="Menampilkan daftar absensi berdasarkan ID karyawan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="karyawan_id",
     *         in="path",
     *         required=true,
     *         description="ID karyawan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data absensi",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Absensi"))
     *     )
     * )
     */
    public function getByKaryawan($karyawan_id)
    {
        $absensis = Absensi::where('karyawan_id', $karyawan_id)->get();
        return response()->json($absensis);
    }

    /**
     * @OA\Get(
     *     path="/absensis/tanggal/{tanggal}",
     *     tags={"Absensi"},
     *     summary="List absensi by tanggal",
     *     description="Menampilkan daftar absensi berdasarkan tanggal",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="tanggal",
     *         in="path",
     *         required=true,
     *         description="Tanggal absensi (format: YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data absensi",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Absensi"))
     *     )
     * )
     */
    public function getByTanggal($tanggal)
    {
        $absensis = Absensi::where('tanggal', $tanggal)->get();
        return response()->json($absensis);
    }
}
