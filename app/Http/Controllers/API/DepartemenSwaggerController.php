<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="DepartemenSwagger",
 *     description="API simulasi Departemen dengan dokumentasi Swagger"
 * )
 */
class DepartemenSwaggerController extends Controller
{
    private $departemen = [
        [
            'id' => 1,
            'nama_departemen' => 'IT',
            'kepala_departemen' => 'Budi Santoso',
            'jumlah_karyawan' => 10,
            'keterangan' => 'Teknologi Informasi',
        ],
        [
            'id' => 2,
            'nama_departemen' => 'HRD',
            'kepala_departemen' => 'Siti Aminah',
            'jumlah_karyawan' => 5,
            'keterangan' => 'Human Resource',
        ],
    ];

    /**
     * @OA\Get(
     *     path="/api/departemen-swagger",
     *     tags={"DepartemenSwagger"},
     *     summary="Menampilkan semua departemen (simulasi)",
     *     @OA\Response(response=200, description="Data departemen ditemukan"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function index()
    {
        return response()->json($this->departemen);
    }

    /**
     * @OA\Post(
     *     path="/api/departemen-swagger",
     *     tags={"DepartemenSwagger"},
     *     summary="Membuat departemen baru (simulasi)",
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
        $data = $request->all();
        $data['id'] = count($this->departemen) + 1;

        return response()->json($data, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/departemen-swagger/{id}",
     *     tags={"DepartemenSwagger"},
     *     summary="Menampilkan detail departemen",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Data departemen ditemukan"),
     *     @OA\Response(response=404, description="Departemen tidak ditemukan"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function show($id)
    {
        $departemen = collect($this->departemen)->firstWhere('id', (int) $id);
        if (!$departemen) {
            return response()->json(['message' => 'Departemen tidak ditemukan'], 404);
        }
        return response()->json($departemen);
    }

    /**
     * @OA\Put(
     *     path="/api/departemen-swagger/{id}",
     *     tags={"DepartemenSwagger"},
     *     summary="Memperbarui departemen (simulasi)",
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
        return response()->json([
            'message' => "Departemen ID $id berhasil diperbarui (simulasi)",
            'data' => $request->all(),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/departemen-swagger/{id}",
     *     tags={"DepartemenSwagger"},
     *     summary="Menghapus departemen (simulasi)",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Departemen berhasil dihapus"),
     *     @OA\Response(response=404, description="Departemen tidak ditemukan"),
     *     @OA\Response(response=500, description="Kesalahan server")
     * )
     */
    public function destroy($id)
    {
        return response()->json(['message' => "Departemen ID $id dihapus (simulasi)"], 204);
    }
}
