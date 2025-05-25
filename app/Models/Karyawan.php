<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{

    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'departemens';

    protected $fillable = [
        'departemen_id',
        'nama',
        'jabatan',
        'gaji_pokok',
        'email',
        'alamat',
        'no_telepon'
    ];

    // Definisikan relasi dengan model Departemen
    public function karyawan()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    // Anda dapat menambahkan metode lain sesuai kebutuhan
}
