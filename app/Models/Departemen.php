<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $fillable  = [
        'nama_departemen',   
        'kepala_departemen',
        'jumlah_karyawan',
        'keterangan'
    ];
}
