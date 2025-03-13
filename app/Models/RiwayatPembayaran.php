<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaran extends Model
{
    protected $fillable  = [
        'gaji_id',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'nominal_pembayaran'
    ];
}
