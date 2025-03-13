<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPembayaran extends Model
{
    protected $fillable  = [
        'periode_laporan',
        'jumlah_karyawan',
        'total_pengeluaran',
        'rata_rata'
    ];
}
