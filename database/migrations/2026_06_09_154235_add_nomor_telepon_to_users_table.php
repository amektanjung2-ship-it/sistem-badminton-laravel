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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom no_hp setelah kolom email, bersifat nullable agar user lama tidak error
            $table->string('no_hp', 15)->nullable()->unique()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
                                         // Menghapus kembali kolom jika migration di-rollback
            $table->dropColumn('no_hp'); // Pastikan nama kolom sesuai dengan yang dibuat di up()
        });
    }
};
