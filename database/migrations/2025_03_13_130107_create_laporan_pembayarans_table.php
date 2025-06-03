<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->date('periode_laporan')->nullable();
            $table->string('jumlah_karyawan');
            $table->string('total_pengeluaran');
            $table->string('rata_rata');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pembayarans');
    }
};
