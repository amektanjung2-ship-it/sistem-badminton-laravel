<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::table('alats', function (Blueprint $table) {
        // Menambahkan kolom enum setelah kolom harga
        $table->enum('jenis_transaksi', ['Sewa', 'Beli'])->default('Sewa')->after('harga_sewa');
    });
}

public function down(): void
{
    Schema::table('alats', function (Blueprint $table) {
        // Untuk jaga-jaga kalau kita mau rollback (membatalkan)
        $table->dropColumn('jenis_transaksi');
    });
}
};
