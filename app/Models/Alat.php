<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $fillable = ['nama_alat', 
        'stok', 
        'harga_sewa', 
        'jenis_transaksi'];
}