<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'gajis';

    // Tentukan kolom yang dapat diisi massal
    protected $fillable = [
        'karyawan_id',
        'periode_gaji',
        'gaji_pokok',
        'total_jam_kerja',
        'bonus',
        'potongan',
        'total_gaji',
    ];

    // Definisikan relasi dengan model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    // Anda dapat menambahkan metode lain sesuai kebutuhan
}