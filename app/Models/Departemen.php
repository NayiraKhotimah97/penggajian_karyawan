<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens'; // Nama tabel di database

    protected $fillable = [
        'nama_departemen',
        'kepala_departemen',
        'jumlah_karyawan',
        'keterangan',
    ];

    /**
     * Relasi: Satu departemen memiliki banyak karyawan
     */
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'id_departemen');
    }
}
