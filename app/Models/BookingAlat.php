<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAlat extends Model
{
    protected $fillable = ['booking_id', 'alat_id', 'jumlah', 'subtotal'];
}
