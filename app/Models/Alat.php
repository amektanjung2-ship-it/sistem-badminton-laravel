<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_alat',
        'harga_sewa',
        'stok',
        'jenis_transaksi',
    ];

    protected $casts = [
        'harga_sewa' => 'integer',
        'stok'       => 'integer',
    ];

    // ✅ FIX: relasi ini sebelumnya tidak ada
    // Dibutuhkan untuk cek sebelum hapus alat
    public function bookingAlats()
    {
        return $this->hasMany(BookingAlat::class);
    }
}