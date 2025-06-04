<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Models\Departemen;

/**
 * @OA\Tag(
 *     name="DepartemenSwagger",
 *     description="API simulasi Departemen dengan dokumentasi Swagger"
 * )
 */
class DepartemenSwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/departemen-swagger",
     *     tags={"DepartemenSwagger"},
     *     summary="Menampilkan semua departemen",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Data departemen ditemukan"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function index()
    {
        $departemens = Departemen::all();
        return response()->json($departemens);
    }

    /**
     * @OA\Post(
     *     path="/departemen-swagger",
     *     tags={"DepartemenSwagger"},
     *     summary="Membuat departemen baru",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_departemen","kepala_departemen","jumlah_karyawan","keterangan"},
     *             @OA\Property(property="nama_departemen", type="string"),
     *             @OA\Property(property="kepala_departemen", type="string"),
     *             @OA\Property(property="jumlah_karyawan", type="integer"),
     *             @OA\Property(property="keterangan", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Departemen berhasil dibuat"),
     *     @OA\Response(response=400, description="Permintaan tidak valid"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'kepala_departemen' => 'required|string|max:255',
            'jumlah_karyawan' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
        ]);
        $departemen = Departemen::create($request->all());
        return response()->json($departemen, 201);
    }

    /**
     * @OA\Get(
     *     path="/departemen-swagger/{id}",
     *     tags={"DepartemenSwagger"},
     *     summary="Menampilkan detail departemen",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Data departemen ditemukan"),
     *     @OA\Response(response=404, description="Departemen tidak ditemukan"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function show($id)
    {
        $departemen = Departemen::find($id);
        if (!$departemen) {
            return response()->json(['message' => 'Departemen tidak ditemukan'], 404);
        }
        return response()->json($departemen);
    }

    /**
     * @OA\Put(
     *     path="/departemen-swagger/{id}",
     *     tags={"DepartemenSwagger"},
     *     summary="Memperbarui departemen",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nama_departemen", type="string"),
     *             @OA\Property(property="kepala_departemen", type="string"),
     *             @OA\Property(property="jumlah_karyawan", type="integer"),
     *             @OA\Property(property="keterangan", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Departemen berhasil diperbarui"),
     *     @OA\Response(response=404, description="Departemen tidak ditemukan"),
     *     @OA\Response(response=400, description="Permintaan tidak valid"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function update(Request $request, $id)
    {
        $departemen = Departemen::find($id);
        if (!$departemen) {
            return response()->json(['message' => 'Departemen tidak ditemukan'], 404);
        }
        $request->validate([
            'nama_departemen' => 'sometimes|required|string|max:255',
            'kepala_departemen' => 'sometimes|required|string|max:255',
            'jumlah_karyawan' => 'sometimes|required|numeric',
            'keterangan' => 'sometimes|required|string|max:255',
        ]);
        $departemen->update($request->all());
        return response()->json($departemen);
    }

    /**
     * @OA\Delete(
     *     path="/departemen-swagger/{id}",
     *     tags={"DepartemenSwagger"},
     *     summary="Menghapus departemen",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Departemen berhasil dihapus"),
     *     @OA\Response(response=404, description="Departemen tidak ditemukan"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function destroy($id)
    {
        $departemen = Departemen::find($id);
        if (!$departemen) {
            return response()->json(['message' => 'Departemen tidak ditemukan'], 404);
        }
        $departemen->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/departemen-swagger/{id}/karyawan",
     *     tags={"DepartemenSwagger"},
     *     summary="Menampilkan detail departemen beserta karyawannya",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Data ditemukan"),
     *     @OA\Response(response=404, description="Departemen tidak ditemukan"),
     * )
     */
    public function getKaryawanByDepartemen($id)
    {
        $departemen = Departemen::with('karyawan')->find($id);
        if (!$departemen) {
            return response()->json(['message' => 'Departemen tidak ditemukan'], 404);
        }
        return response()->json($departemen);
    }
}
