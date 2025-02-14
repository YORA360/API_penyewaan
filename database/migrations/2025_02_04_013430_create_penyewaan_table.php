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
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->id('penyewaan_id');
            $table->foreignId('penyewaan_pelanggan_id')->constrained('pelanggan','pelanggan_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('penyewaan_tglSewa');
            $table->date('penyewaan_tglKembali');
            $table->enum('status_pembayaran',['Lunas','Belum_Dibayar','DP'])->default('Belum_Dibayar');
            $table->enum('status_pengembalian',['Sudah_Kembali','Belum_Kembali'])->default('Belum_Kembali');
            $table->integer('penyewaan_totalHarga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
