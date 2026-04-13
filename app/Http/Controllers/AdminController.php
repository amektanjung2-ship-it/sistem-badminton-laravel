<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Alat;

class AdminController extends Controller
{
    // 1. Fungsi ini KHUSUS untuk menampilkan halaman Dashboard Admin
    public function index()
    {
        // Mengambil semua data booking, diurutkan dari yang terbaru
        $bookings = Booking::with(['user', 'lapangan'])->latest()->get();

        $total_lapangan = Lapangan::count();
        $total_alat = Alat::count();

        return view('admin.dashboard', compact('bookings', 'total_lapangan', 'total_alat'));
    }

    // 2. Fungsi ini KHUSUS untuk mengubah status saat tombol diklik
    public function updateStatus(Request $request, Booking $booking)
    {
        // Validasi input agar hanya menerima 3 status ini
        $request->validate([
            'status_pembayaran' => 'required|in:pending,lunas,batal'
        ]);

        // Update status di database
        $booking->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        // Kembalikan ke halaman dashboard admin dengan pesan sukses
        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . strtoupper($request->status_pembayaran) . '!');
    }
    // FUNGSI UNTUK HALAMAN LAPORAN PENDAPATAN
    public function laporan()
    {
        // 1. Tarik semua data pesanan yang statusnya SUDAH LUNAS
        $bookings = Booking::with(['user', 'lapangan'])
            ->whereRaw("LOWER(status_pembayaran) = 'lunas'")
            ->latest()
            ->get();

        // 2. Mesin Penghitung Kasir (Otomatis menjumlahkan uang)
        $totalPendapatan = $bookings->sum('total_harga');
        $totalTransaksi = $bookings->count();

        // 3. Kirim datanya ke halaman view laporan
        return view('admin.laporan', compact('bookings', 'totalPendapatan', 'totalTransaksi'));
    }
}
