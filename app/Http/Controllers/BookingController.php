<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Alat;
use App\Models\Booking;
use App\Models\BookingAlat;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Menampilkan halaman form booking
    public function create(Lapangan $lapangan)
    {
        $alats = Alat::where('stok', '>', 0)->get();
        return view('booking.create', compact('lapangan', 'alats'));
    }

    // Memproses data yang dikirim dari form
    public function store(Request $request, Lapangan $lapangan)
    {
        // 1. Validasi Input (Durasi sekarang bisa desimal, misal: 1.5 untuk 1,5 jam)
        $request->validate([
            'tanggal_main' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|numeric|min:0.5' // Minimal sewa 30 menit
        ]);

        // 2. Hitung Jam Selesai secara otomatis (AKURAT BERDASARKAN MENIT)
        $jam_mulai = $request->jam_mulai;
        $menit = $request->durasi * 60; // Ubah durasi ke menit
        $jam_selesai = date('H:i', strtotime($jam_mulai . " + {$menit} minutes"));

        // 3. LOGIKA ANTI BENTROK
        $bentrok = Booking::where('lapangan_id', $lapangan->id)
            ->where('tanggal_main', $request->tanggal_main)
            ->where('status_pembayaran', '!=', 'batal') // Pastikan status batal tidak dihitung
            ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                $query->where('jam_mulai', '<', $jam_selesai)
                    ->where('jam_selesai', '>', $jam_mulai);
            })->exists();

        if ($bentrok) {
            return back()->with('error', 'Maaf! Lapangan ini sudah dipesan pada jam tersebut. Silakan pilih jam lain.');
        }

        // 4. LOGIKA VALIDASI STOK ALAT
        if ($request->has('alat')) {
            foreach ($request->alat as $alat_id => $jumlah) {
                if ($jumlah > 0) {
                    $alat = Alat::find($alat_id);

                    // JIKA BARANG SEWA (Contoh: Raket, Sepatu)
                    if ($alat->jenis_transaksi == 'Sewa') {
                        $terpakai = BookingAlat::join('bookings', 'booking_alats.booking_id', '=', 'bookings.id')
                            ->where('booking_alats.alat_id', $alat_id)
                            ->where('bookings.tanggal_main', $request->tanggal_main)
                            ->where('bookings.jam_mulai', '<', $jam_selesai)
                            ->where('bookings.jam_selesai', '>', $jam_mulai)
                            ->where('bookings.status_pembayaran', '!=', 'batal')
                            ->sum('booking_alats.jumlah');

                        $sisa_stok = $alat->stok - $terpakai;

                        if ($jumlah > $sisa_stok) {
                            return back()->with('error', "Maaf, sisa {$alat->nama_barang} di jam tersebut hanya tinggal {$sisa_stok}.");
                        }
                    }
                    // JIKA BARANG BELI (Contoh: Kok, Air Minum)
                    else {
                        if ($jumlah > $alat->stok) {
                            return back()->with('error', "Maaf, fisik stok {$alat->nama_barang} tidak mencukupi. Sisa: {$alat->stok}");
                        }
                    }
                }
            }
        }

        // 5. HITUNG HARGA (Akurat sesuai durasi)
        $total_harga_lapangan = $lapangan->harga_per_jam * $request->durasi;
        $total_harga_alat = 0;

        if ($request->has('alat')) {
            foreach ($request->alat as $alat_id => $jumlah) {
                if ($jumlah > 0) {
                    $alat = Alat::find($alat_id);
                    $total_harga_alat += ($alat->harga_sewa * $jumlah);
                }
            }
        }

        // Gabungkan total harga
        $total_keseluruhan = $total_harga_lapangan + $total_harga_alat;

        // 👇 LOGIKA DISKON MEMBER (Diperbaiki: Ditaruh di luar looping alat) 👇
        if ($request->user()->is_member) {
            $diskon = $total_keseluruhan * 0.10; // Diskon 10%
            $total_keseluruhan = $total_keseluruhan - $diskon;
        }

        // 6. SIMPAN KE TABEL BOOKINGS
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $lapangan->id,
            'tanggal_main' => $request->tanggal_main,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'total_harga' => $total_keseluruhan,
            'status_pembayaran' => 'pending'
        ]);

        // 7. SIMPAN KE TABEL BOOKING_ALATS & KURANGI STOK
        if ($request->has('alat')) {
            foreach ($request->alat as $alat_id => $jumlah) {
                if ($jumlah > 0) {
                    $alat = Alat::find($alat_id);

                    BookingAlat::create([
                        'booking_id' => $booking->id,
                        'alat_id' => $alat_id,
                        'jumlah' => $jumlah,
                        'subtotal' => $alat->harga_sewa * $jumlah
                    ]);

                    if ($alat->jenis_transaksi == 'Beli') {
                        $alat->decrement('stok', $jumlah);
                    }
                }
            }
        }

        // 8. KEMBALI KE DASHBOARD DENGAN PESAN SUKSES
        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat! Total tagihan Anda: Rp ' . number_format($total_keseluruhan, 0, ',', '.'));
    }

    // Fungsi baru untuk API JavaScript (Kalender Presisi!)
    public function cekJadwal(Request $request, Lapangan $lapangan)
    {
        $tanggal = $request->query('tanggal');

        // Cari pesanan di lapangan dan tanggal tersebut yang tidak batal
        $bookings = Booking::where('lapangan_id', $lapangan->id)
            ->where('tanggal_main', $tanggal)
            ->where('status_pembayaran', '!=', 'batal')
            ->get(['jam_mulai', 'jam_selesai']);

        $jadwal_terpakai = [];

        foreach ($bookings as $booking) {
            // Sekarang kita kembalikan waktu pasti (contoh: start: 08:15:00, end: 09:45:00)
            // Bukan lagi angka integer yang buta huruf!
            $jadwal_terpakai[] = [
                'start' => $booking->jam_mulai,
                'end' => $booking->jam_selesai
            ];
        }

        // Kirim balasannya dalam format JSON
        return response()->json([
            'terpakai' => $jadwal_terpakai
        ]);
    }
}