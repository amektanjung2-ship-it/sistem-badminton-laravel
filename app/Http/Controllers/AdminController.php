<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Alat;

class AdminController extends Controller
{
    // 1. Fungsi Utama Dashboard Admin
    public function index(Request $request)
    {
        // A. Fitur Pencarian
        $search = $request->input('search');

        // B. Query Data Booking (Terintegrasi dengan Search)
        $bookings = Booking::with(['user', 'lapangan'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('lapangan', function ($q) use ($search) {
                    $q->where('nama_lapangan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        // C. Statistik Ringkasan
        $total_lapangan = Lapangan::count();
        $total_alat = Alat::sum('stok');

        // D. Logika Grafik (7 Hari Terakhir)
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');

            $income = Booking::whereDate('created_at', $date)
                ->whereRaw("LOWER(status_pembayaran) = 'lunas'")
                ->sum('total_harga');
            $data[] = $income;
        }

        // E. KIRIM SEMUA DATA (Hanya satu return di paling bawah)
        return view('admin.dashboard', compact(
            'total_lapangan',
            'total_alat',
            'bookings',
            'labels',
            'data'
        ));
    }

    // 2. Fungsi Update Status (ACC/Tolak)
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,lunas,batal'
        ]);

        $booking->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // 3. Fungsi Halaman Laporan
    public function laporan()
    {
        $bookings = Booking::with(['user', 'lapangan'])
            ->whereRaw("LOWER(status_pembayaran) = 'lunas'")
            ->latest()
            ->get();

        $totalPendapatan = $bookings->sum('total_harga');
        $totalTransaksi = $bookings->count();

        return view('admin.laporan', compact('bookings', 'totalPendapatan', 'totalTransaksi'));
    }
}
