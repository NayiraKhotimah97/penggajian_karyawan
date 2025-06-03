<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaran extends Model
{
    protected $fillable = [
        'id_gaji',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'nominal_pembayaran'
    ];

    public function gaji()
    {
        return $this->belongsTo(Gaji::class, 'id_gaji');
    }

}
