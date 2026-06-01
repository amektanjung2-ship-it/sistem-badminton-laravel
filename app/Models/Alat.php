<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Tambahkan baris ini

class Alat extends Model
{
    use HasFactory, SoftDeletes; // 2. Tambahkan SoftDeletes di sebelah HasFactory

    protected $fillable = [
        'nama_alat',
        'harga_sewa',
        'stok',
        'jenis_transaksi',
    ];

    protected $casts = [
        'harga_sewa' => 'integer',
        'stok'       => 'integer',
    ];

    /**
     * Relasi ke tabel BookingAlat.
     * Digunakan untuk validasi sebelum penghapusan data master alat.
     */
    public function bookingAlats()
    {
        return $this->hasMany(BookingAlat::class);
    }

    /**
     * Accessor untuk menghitung jumlah barang yang sedang disewa secara real-time.
     * Mengembalikan nilai 0 untuk barang bertipe 'Beli'.
     */
    public function getSedangDisewaAttribute()
    {
        if (strtolower($this->jenis_transaksi) == 'beli') {
            return 0;
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggal_sekarang = date('Y-m-d');
        $waktu_sekarang = date('H:i');

        $terpakai = \App\Models\BookingAlat::join('bookings', 'booking_alats.booking_id', '=', 'bookings.id')
            ->where('booking_alats.alat_id', $this->id)
            ->where('bookings.tanggal_main', $tanggal_sekarang)
            ->where('bookings.jam_mulai', '<=', $waktu_sekarang)
            ->where('bookings.jam_selesai', '>', $waktu_sekarang)
            ->whereRaw("LOWER(bookings.status_pembayaran) != 'batal'")
            ->sum('booking_alats.jumlah');

        return (int) $terpakai;
    }
}