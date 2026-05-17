<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Alat;
use App\Models\BookingAlat; // Pastikan ini di-import
use App\Models\User; // Pastikan ini di-import

class AdminController extends Controller
{
    // 1. Fungsi Utama Dashboard Admin
    public function index(Request $request)
    {
        // A. Fitur Pencarian Data Booking
        $search = $request->input('search');
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

        // B. Statistik Ringkasan
        $total_lapangan = Lapangan::count();
        $total_alat = Alat::sum('stok');

        // 👇 C. LOGIKA GRAFIK DINAMIS (BISA FILTER) 👇
        $periode = $request->input('periode', '7_days'); // Default 7 hari
        $labels = [];
        $data = [];

        // Tentukan rentang waktu berdasarkan filter yang dipilih
        if ($periode == 'this_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($periode == 'last_month') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } else {
            // Default: 7 Hari Terakhir
            $startDate = now()->subDays(6);
            $endDate = now();
        }

        // Looping dari tanggal awal ke tanggal akhir untuk membuat grafik
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d M');
            
            // Hitung total pendapatan (Lunas) di hari tersebut
            $income = Booking::whereDate('created_at', $currentDate->format('Y-m-d'))
                ->whereRaw("LOWER(status_pembayaran) = 'lunas'")
                ->sum('total_harga');
            
            $data[] = $income;

            // Lanjut ke hari berikutnya
            $currentDate->addDay();
        }
        // 👆 BATAS LOGIKA GRAFIK DINAMIS 👆

        return view('admin.dashboard', compact(
            'total_lapangan',
            'total_alat',
            'bookings',
            'labels',
            'data',
            'periode' // Kirim data periode yang aktif ke tampilan
        ));
    }

    // 2. Fungsi Update Status (ACC/Tolak) - VERSI CERDAS (FIX BUG STOK)
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,lunas,batal'
        ]);

        $statusLama = $booking->status_pembayaran;
        $statusBaru = $request->status_pembayaran;

        // 🛡️ LOGIKA PENGEMBALIAN STOK (Data Integrity)
        // Jika status berubah dari (Pending/Lunas) menjadi BATAL
        if ($statusLama != 'batal' && $statusBaru == 'batal') {
            
            // Ambil semua detail item (Alat/Barang) di pesanan ini
            $items = BookingAlat::where('booking_id', $booking->id)->get();
            
            foreach ($items as $item) {
                $alat = Alat::find($item->alat_id);
                
                // Jika barang tersebut jenisnya 'Beli' (Kok, Minuman, dll), kembalikan stoknya
                if ($alat && $alat->jenis_transaksi == 'Beli') {
                    $alat->increment('stok', $item->jumlah);
                }
            }
        }

        // Sebaliknya: Jika Admin memulihkan pesanan yang batal (Batal -> Lunas/Pending)
        if ($statusLama == 'batal' && $statusBaru != 'batal') {
            $items = BookingAlat::where('booking_id', $booking->id)->get();
            
            foreach ($items as $item) {
                $alat = Alat::find($item->alat_id);
                if ($alat && $alat->jenis_transaksi == 'Beli') {
                    // Cek dulu stoknya cukup tidak untuk dikurangi lagi
                    if ($alat->stok >= $item->jumlah) {
                        $alat->decrement('stok', $item->jumlah);
                    } else {
                        return back()->with('error', "Gagal memulihkan! Stok {$alat->nama_alat} tidak cukup di gudang.");
                    }
                }
            }
        }

        // Update status di database
        $booking->update([
            'status_pembayaran' => $statusBaru
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . strtoupper($statusBaru));
    }

    // 3. Fungsi Halaman Laporan Keuangan
    public function laporan(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Booking::with(['user', 'lapangan'])->whereRaw("LOWER(status_pembayaran) = 'lunas'");

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_main', [$start_date, $end_date]);
        }

        $bookings = $query->latest()->get();
        $total_keseluruhan = $bookings->sum('total_harga');
        $booking_ids = $bookings->pluck('id');
        $total_alat = BookingAlat::whereIn('booking_id', $booking_ids)->sum('subtotal');
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
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Booking::with(['user', 'lapangan'])->whereRaw("LOWER(status_pembayaran) = 'lunas'");

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_main', [$start_date, $end_date]);
        }

        $bookings = $query->latest()->get();
        $total_keseluruhan = $bookings->sum('total_harga');
        $total_alat = BookingAlat::whereIn('booking_id', $bookings->pluck('id'))->sum('subtotal');
        $total_lapangan = $total_keseluruhan - $total_alat;

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

    // 4. Fungsi Member Toggle
    public function toggleMember($id)
    {
        $user = User::findOrFail($id);
        $user->is_member = !$user->is_member;
        $user->save();

        $status = $user->is_member ? 'dijadikan Member' : 'dicabut status Membernya';
        return back()->with('success', "Akun {$user->name} berhasil {$status}!");
    }

    // 5. Daftar Pelanggan
    public function daftarPelanggan()
    {
        $users = User::latest()->get();
        return view('admin.pelanggan', compact('users'));
    }
}