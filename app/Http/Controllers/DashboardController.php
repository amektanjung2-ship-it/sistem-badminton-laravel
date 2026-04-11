<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Alat;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil semua data lapangan yang statusnya aktif
        $lapangans = Lapangan::where('status_aktif', true)->get();

        // Mengambil semua data alat yang stoknya lebih dari 0
        $alats = Alat::where('stok', '>', 0)->get();
        $riwayat_bookings = Booking::with('lapangan')
            ->where('user_id', auth::id())
            ->latest()
            ->get();
        // Mengirim data ke view dashboard.blade.php
        return view('dashboard', compact('lapangans', 'alats', 'riwayat_bookings'));
    }
}
