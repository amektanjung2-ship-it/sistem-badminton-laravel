<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\Admin\AlatController;

Route::get('/', function () {
    return view('welcome');
});

// --- RUTE PELANGGAN BIASA ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// PINDAHKAN KEDUA BARIS INI KE SINI (Di luar grup admin) 👇
Route::get('/tiket/{booking}', [DashboardController::class, 'cetakTiket'])->middleware(['auth', 'verified'])->name('cetak.tiket');
Route::get('/tiket/download/{booking}', [DashboardController::class, 'downloadPdf'])->middleware(['auth', 'verified'])->name('tiket.pdf');

// Rute Booking
Route::get('/booking/{lapangan}', [BookingController::class, 'create'])->middleware(['auth', 'verified'])->name('booking.create');
Route::post('/booking/{lapangan}', [BookingController::class, 'store'])->middleware(['auth', 'verified'])->name('booking.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ROUTE GROUP KHUSUS ADMIN ---
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    // ROUTE UNTUK KELOLA ALAT
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    Route::get('/alat/tambah', [AlatController::class, 'create'])->name('alat.create');
    Route::post('/alat/simpan', [AlatController::class, 'store'])->name('alat.store');
    Route::get('/alat/{alat}/edit', [AlatController::class, 'edit'])->name('alat.edit');
    Route::put('/alat/{alat}', [AlatController::class, 'update'])->name('alat.update');
    Route::delete('/alat/{alat}', [AlatController::class, 'destroy'])->name('alat.destroy');

    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    // Status Pembayaran
    Route::patch('/booking/{booking}/status', [AdminController::class, 'updateStatus'])->name('booking.updateStatus');

    // Kelola Lapangan
    Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/tambah', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan/simpan', [LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/{lapangan}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::put('/lapangan/{lapangan}', [LapanganController::class, 'update'])->name('lapangan.update');
    Route::delete('/lapangan/{lapangan}', [LapanganController::class, 'destroy'])->name('lapangan.destroy');
});

require __DIR__ . '/auth.php';
