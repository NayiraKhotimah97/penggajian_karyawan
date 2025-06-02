<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans'; // atau nama yang sesuai di database

    protected $fillable = [
        'departemen_id',
        'nama',
        'jabatan',
        'gaji_pokok',
        'email',
        'alamat',
        'no_telepon'
    ];

    // Relasi ke Departemen
    public function departemen()
    {
    return $this->belongsTo(Departemen::class, 'id_departemen');
    }
}
