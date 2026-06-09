<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureNoWaIsFilled;
use App\Http\Middleware\IsAdmin; // Disatukan di atas
use App\Models\Lapangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// Disatukan di atas

// ==========================================
// RUTE HALAMAN UTAMA (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    // Mengambil semua data lapangan untuk ditampilkan di katalog beranda
    $lapangans = Lapangan::all();
    return view('welcome', compact('lapangans'));
});

// ==========================================
// RUTE KHUSUS PENGISIAN NOMOR HP (PENGGUNA LAMA)
// ==========================================
// Harus bisa diakses saat login tapi nomor WA masih kosong di database
Route::middleware(['auth'])->group(function () {
    Route::get('/lengkapi-profil', function () {
        // PERBAIKAN: Mengubah nomor_telepon menjadi no_hp sesuai properti Model User Anda
        if (! empty(Auth::user()->no_hp)) {
            return redirect()->route('dashboard'); // Kalau sudah ada no WA, langsung balikkan ke dashboard
        }
        return view('auth.lengkapi-profil');
    })->name('profil.lengkapi');

    Route::post('/lengkapi-profil', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'no_hp' => ['required', 'string', 'max:15', 'unique:users,no_hp,' . Auth::id()],
        ]);

        $user        = Auth::user();
        $user->no_hp = $request->no_hp; // Dipastikan menggunakan no_hp
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Nomor WhatsApp berhasil diperbarui!');
    })->name('profil.update-nomor');
});

// ==========================================
// RUTE PELANGGAN BIASA (WAJIB LOGIN & ISI WA)
// ==========================================
Route::middleware(['auth', 'verified', EnsureNoWaIsFilled::class])->group(function () {

    // Halaman Utama Dashboard Pelanggan
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tiket & Laporan Pelanggan
    Route::get('/tiket/{booking}', [DashboardController::class, 'cetakTiket'])->name('cetak.tiket');
    Route::get('/tiket/download/{booking}', [DashboardController::class, 'downloadPdf'])->name('tiket.pdf');

    // Rute Booking Lapangan
    Route::get('/booking/{lapangan}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{lapangan}', [BookingController::class, 'store'])->name('booking.store');

    // Batalkan Booking oleh Pelanggan (hanya untuk status pending)
    Route::patch('/booking/{booking}/batalkan', [BookingController::class, 'batalkan'])->name('booking.batalkan');
});

// Cek Jadwal (API) — dibatasi 60 request per menit per IP agar tidak bisa dispam
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/api/jadwal/{lapangan}', [BookingController::class, 'cekJadwal'])->name('api.jadwal');
});

// Profil Pengguna (Bawaan Laravel Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// RUTE KHUSUS ADMIN (DILINDUNGI MIDDLEWARE)
// ==========================================
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Daftar Pelanggan & Tombol Member (Fix Prefix)
    Route::get('/pelanggan', [AdminController::class, 'daftarPelanggan'])->name('pelanggan');
    Route::patch('/pelanggan/{id}/member', [AdminController::class, 'toggleMember'])->name('pelanggan.member');

    // Laporan Keuangan & Update Status Booking
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/pdf', [AdminController::class, 'downloadLaporanPDF'])->name('laporan.pdf');
    Route::patch('/booking/{booking}/status', [AdminController::class, 'updateStatus'])->name('booking.updateStatus');

    // Kelola Data Lapangan
    Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/tambah', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan/simpan', [LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/{lapangan}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::put('/lapangan/{lapangan}', [LapanganController::class, 'update'])->name('lapangan.update');
    Route::delete('/lapangan/{lapangan}', [LapanganController::class, 'destroy'])->name('lapangan.destroy');

    // Kelola Data Alat/Barang
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    Route::get('/alat/tambah', [AlatController::class, 'create'])->name('alat.create');
    Route::post('/alat/simpan', [AlatController::class, 'store'])->name('alat.store');
    Route::get('/alat/{alat}/edit', [AlatController::class, 'edit'])->name('alat.edit');
    Route::put('/alat/{alat}', [AlatController::class, 'update'])->name('alat.update');
    Route::delete('/alat/{alat}', [AlatController::class, 'destroy'])->name('alat.destroy');
});

require __DIR__ . '/auth.php';
