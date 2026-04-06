<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('alats', function (Blueprint $table) {
        $table->id();
        $table->string('nama_alat'); // Contoh: Raket Yonex, Sepatu Li-Ning
        $table->integer('harga_sewa'); // Harga sewa per sesi/jam
        $table->integer('stok'); // Jumlah barang fisik yang ada
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
