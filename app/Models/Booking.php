<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 
        'lapangan_id', 
        'tanggal_main', 
        'jam_mulai', 
        'jam_selesai', 
        'total_harga', 
        'status_pembayaran'
    ];

    // Relasi: Satu Booking dimiliki oleh satu User (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu Booking menempati satu Lapangan
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}