<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Alat;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil semua data lapangan yang statusnya aktif
        $lapangans = Lapangan::where('status_aktif', true)->get();

        // Mengambil semua data alat yang stoknya lebih dari 0
        $alats = Alat::where('stok', '>', 0)->get();
        
        $riwayat_bookings = Booking::with('lapangan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Kalkulasi untuk Bilah Kemajuan (Progress Bar) VIP
        $totalTransaksiLunas = Booking::where('user_id', Auth::id())
            ->where('status_pembayaran', 'lunas')
            ->count();

        $totalPengeluaranLunas = Booking::where('user_id', Auth::id())
            ->where('status_pembayaran', 'lunas')
            ->sum('total_harga');

        // Hitung persentase & sisa — selesaikan di controller agar blade bersih
        $targetTransaksi    = 10;
        $targetPengeluaran  = 300000;
        $pctTransaksi       = min(100, (int) round(($totalTransaksiLunas / $targetTransaksi) * 100));
        $pctPengeluaran     = min(100, (int) round(($totalPengeluaranLunas / $targetPengeluaran) * 100));
        $sisaTransaksi      = max(0, $targetTransaksi - $totalTransaksiLunas);
        $sisaPengeluaran    = max(0, $targetPengeluaran - $totalPengeluaranLunas);


        // Mengirim data ke view dashboard.blade.php
        return view('dashboard', compact(
            'lapangans',
            'alats',
            'riwayat_bookings',
            'totalTransaksiLunas',
            'totalPengeluaranLunas',
            'targetTransaksi',
            'targetPengeluaran',
            'pctTransaksi',
            'pctPengeluaran',
            'sisaTransaksi',
            'sisaPengeluaran'
        ));
    }

    public function cetakTiket(Booking $booking)
    {
        // Keamanan: Cek pemilik
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mencetak tiket ini.');
        }

        return view('tiket', compact('booking'));
    }

    public function downloadPdf(Booking $booking)
    {
        // Keamanan: Cek pemilik
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mendownload tiket ini.');
        }

        // Load view tiket ke dalam mesin PDF
        $pdf = Pdf::loadView('tiket', compact('booking'));

        // Download file dengan nama yang rapi
        return $pdf->download('Tiket-Booking-' . $booking->id . '.pdf');
    }
}