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
    Schema::create('lapangans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lapangan');
        $table->integer('harga_per_jam');
        $table->boolean('status_aktif')->default(true); // true = bisa disewa, false = rusak/perbaikan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
