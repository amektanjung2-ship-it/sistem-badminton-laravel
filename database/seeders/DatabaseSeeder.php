<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Alat;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Password login: password
            'role' => 'admin',
            'no_hp' => '081234567890'
        ]);

        // 2. Buat Data Lapangan
        Lapangan::create(['nama_lapangan' => 'Lapangan VIP A', 'harga_per_jam' => 50000]);
        Lapangan::create(['nama_lapangan' => 'Lapangan Reguler B', 'harga_per_jam' => 35000]);

        // 3. Buat Data Alat
        Alat::create(['nama_alat' => 'Raket Yonex', 'harga_sewa' => 10000, 'stok' => 10]);
        Alat::create(['nama_alat' => 'Sepatu Li-Ning (Ukuran 42)', 'harga_sewa' => 15000, 'stok' => 5]);
        Alat::create(['nama_alat' => 'Kok (Shuttlecock) / Slop', 'harga_sewa' => 20000, 'stok' => 20]);
    }
}