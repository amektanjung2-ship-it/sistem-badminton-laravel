<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Alat;
use App\Models\BookingAlat;
use App\Models\User;

class AdminController extends Controller
{
    // 1. Fungsi Utama Dashboard Admin
    public function index(Request $request)
    {
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

        $total_lapangan = Lapangan::count();
        $total_alat = Alat::sum('stok');

        $periode = $request->input('periode', '7_days');
        $labels = [];
        $data = [];

        if ($periode == 'this_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($periode == 'last_month') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } else {
            $startDate = now()->subDays(6);
            $endDate = now();
        }

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d M');
            
            $income = Booking::whereDate('created_at', $currentDate->format('Y-m-d'))
                ->whereRaw("LOWER(status_pembayaran) = 'lunas'")
                ->sum('total_harga');
            
            $data[] = $income;
            $currentDate->addDay();
        }

        return view('admin.dashboard', compact(
            'total_lapangan',
            'total_alat',
            'bookings',
            'labels',
            'data',
            'periode'
        ));
    }

    // 2. Fungsi Update Status (ACC/Tolak)
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,lunas,batal'
        ]);

        $statusLama = $booking->status_pembayaran;
        $statusBaru = $request->status_pembayaran;

        // Logika 1: Pengembalian Stok
        if ($statusLama != 'batal' && $statusBaru == 'batal') {
            $items = BookingAlat::where('booking_id', $booking->id)->get();
            
            foreach ($items as $item) {
                $alat = Alat::find($item->alat_id);
                if ($alat && strtolower($alat->jenis_transaksi) == 'beli') {
                    $alat->increment('stok', $item->jumlah);
                }
            }
        }

        // Logika 2: Pemulihan Stok
        if ($statusLama == 'batal' && $statusBaru != 'batal') {
            $items = BookingAlat::where('booking_id', $booking->id)->get();
            
            foreach ($items as $item) {
                $alat = Alat::find($item->alat_id);
                if ($alat && strtolower($alat->jenis_transaksi) == 'beli') {
                    if ($alat->stok >= $item->jumlah) {
                        $alat->decrement('stok', $item->jumlah);
                    } else {
                        return back()->with('error', "Gagal memulihkan! Stok {$alat->nama_alat} tidak cukup di gudang.");
                    }
                }
            }
        }

        $booking->update([
            'status_pembayaran' => $statusBaru
        ]);

        // Logika 3: Peningkatan Status VIP Otomatis
        if ($statusBaru === 'lunas' && !$booking->user->is_member) {
            
            $user = $booking->user;

            $totalTransaksi = Booking::where('user_id', $user->id)
                ->where('status_pembayaran', 'lunas')
                ->count();

            $totalPengeluaran = Booking::where('user_id', $user->id)
                ->where('status_pembayaran', 'lunas')
                ->sum('total_harga');

            if ($totalTransaksi >= 10 || $totalPengeluaran >= 300000) {
                $user->update([
                    'is_member' => true
                ]);

                return back()->with('success', 'Status pesanan berhasil diperbarui menjadi Lunas. Pelanggan ini telah otomatis ditingkatkan menjadi Member VIP karena memenuhi syarat transaksi!');
            }
        }

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
    public function toggleMember(string $id)
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
        $pelanggans = User::where('role', '!=', 'admin')->latest()->get();
        
        return view('admin.pelanggan', compact('pelanggans'));
    }
}