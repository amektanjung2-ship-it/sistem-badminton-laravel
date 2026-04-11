<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\LapanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/booking/{lapangan}', [BookingController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('booking.create');

Route::get('/booking/{lapangan}', [BookingController::class, 'create'])->middleware(['auth', 'verified'])->name('booking.create');


Route::post('/booking/{lapangan}', [BookingController::class, 'store'])->middleware(['auth', 'verified'])->name('booking.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); // Route Group Khusus Admin
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {

    // URL: localhost:8000/admin/dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Nanti kita akan tambahkan route untuk edit lapangan/alat di sini...
    // Route untuk mengubah status pembayaran
    Route::patch('/booking/{booking}/status', [AdminController::class, 'updateStatus'])->name('booking.updateStatus');
    Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/tambah', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan/simpan', [LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/{lapangan}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::put('/lapangan/{lapangan}', [LapanganController::class, 'update'])->name('lapangan.update');
    Route::delete('/lapangan/{lapangan}', [LapanganController::class, 'destroy'])->name('lapangan.destroy');
});
require __DIR__ . '/auth.php';
