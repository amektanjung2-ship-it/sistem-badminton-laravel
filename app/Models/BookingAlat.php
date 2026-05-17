<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'alat_id',
        'jumlah',
        'subtotal',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // ✅ FIX: relasi ini sebelumnya tidak ada
    // Dibutuhkan oleh tiket.blade.php untuk tampilkan nama alat
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}