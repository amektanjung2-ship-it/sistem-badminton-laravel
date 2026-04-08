<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Alat;

class BookingController extends Controller
{
    public function create(Lapangan $lapangan)
    {
        // Ambil data alat yang stoknya masih ada
        $alats = Alat::where('stok', '>', 0)->get();

        // Tampilkan halaman form booking, kirim data lapangan & alat
        return view('booking.create', compact('lapangan', 'alats'));
    }
}