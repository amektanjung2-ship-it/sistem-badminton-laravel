<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Alat;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil semua data lapangan yang statusnya aktif
        $lapangans = Lapangan::where('status_aktif', true)->get();
        
        // Mengambil semua data alat yang stoknya lebih dari 0
        $alats = Alat::where('stok', '>', 0)->get();

        // Mengirim data ke view dashboard.blade.php
        return view('dashboard', compact('lapangans', 'alats'));
    }
}