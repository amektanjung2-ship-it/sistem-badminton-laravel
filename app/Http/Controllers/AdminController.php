<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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

    // 3. Fungsi Halaman Laporan Keuangan (Canggih)
    public function laporan(Request $request)
    {
        // A. Tangkap inputan tanggal dari form filter
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // B. Buat Query Dasar (Hanya ambil pesanan yang LUNAS)
        $query = Booking::with(['user', 'lapangan'])->whereRaw("LOWER(status_pembayaran) = 'lunas'");

        // C. Jika Admin mengisi filter tanggal, terapkan filter tersebut
        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_main', [$start_date, $end_date]);
        }

        // Eksekusi pencarian data
        $bookings = $query->latest()->get();

        // D. Hitung Keuangan (Pisahkan Lapangan & Alat)
        $total_keseluruhan = $bookings->sum('total_harga');

        // Ambil semua ID booking yang sudah terfilter untuk mencari alatnya
        $booking_ids = $bookings->pluck('id');

        // Ambil total uang khusus dari penyewaan/pembelian alat
        $total_alat = \App\Models\BookingAlat::whereIn('booking_id', $booking_ids)->sum('subtotal');

        // Total uang murni dari lapangan = Total Keseluruhan dikurangi Total Alat
        $total_lapangan = $total_keseluruhan - $total_alat;

        return view('admin.laporan', compact(
            'bookings',
            'total_keseluruhan',
            'total_lapangan',
            'total_alat',
            'start_date',
            'end_date'
        ));
    }
    public function downloadLaporanPDF(Request $request)
    {
        // Logika filter yang sama dengan halaman laporan
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Booking::with(['user', 'lapangan'])->whereRaw("LOWER(status_pembayaran) = 'lunas'");

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_main', [$start_date, $end_date]);
        }

        $bookings = $query->latest()->get();

        $total_keseluruhan = $bookings->sum('total_harga');
        $total_alat = \App\Models\BookingAlat::whereIn('booking_id', $bookings->pluck('id'))->sum('subtotal');
        $total_lapangan = $total_keseluruhan - $total_alat;

        // Menyiapkan data untuk dikirim ke file PDF
        $pdf = Pdf::loadView('admin.laporan_pdf', compact(
            'bookings',
            'total_keseluruhan',
            'total_lapangan',
            'total_alat',
            'start_date',
            'end_date'
        ));

        return $pdf->download('Laporan-Keuangan-GOR.pdf');
    }
    // Fungsi untuk mengubah status Member (On/Off)
    public function toggleMember($id)
    {
        // Cari user berdasarkan ID
        $user = \App\Models\User::findOrFail($id);

        // Ubah statusnya jadi kebalikannya (Kalau 0 jadi 1, kalau 1 jadi 0)
        $user->is_member = !$user->is_member;
        $user->save();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        $status = $user->is_member ? 'dijadikan Member' : 'dicabut status Membernya';
        return back()->with('success', "Akun {$user->name} berhasil {$status}!");
    }
    // Fungsi untuk menampilkan halaman Daftar Pelanggan
    public function daftarPelanggan()
    {
        // Ambil semua data user dari database (diurutkan dari yang terbaru)
        $users = \App\Models\User::latest()->get();

        return view('admin.pelanggan', compact('users'));
    }
}
