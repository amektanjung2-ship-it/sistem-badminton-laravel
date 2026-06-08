<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapangan_id',
        'nama_pemesan',
        'tanggal_main',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_main' => 'date',
        'total_harga'  => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    // ✅ FIX: relasi ini sebelumnya tidak ada
    // Dibutuhkan oleh tiket.blade.php dan laporan admin
    public function bookingAlats()
    {
        return $this->hasMany(BookingAlat::class);
    }
}