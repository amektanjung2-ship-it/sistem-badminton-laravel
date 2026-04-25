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
        // 1. Validasi Input
        $request->validate([
            'tanggal_main' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|min:1'
        ]);

        // 2. Hitung Jam Selesai secara otomatis
        $jam_mulai = $request->jam_mulai;
        $jam_selesai = date('H:i', strtotime($jam_mulai . " + {$request->durasi} hours"));

        // 3. LOGIKA ANTI BENTROK
        $bentrok = Booking::where('lapangan_id', $lapangan->id)
            ->where('tanggal_main', $request->tanggal_main)
            ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                $query->where('jam_mulai', '<', $jam_selesai)
                    ->where('jam_selesai', '>', $jam_mulai);
            })->exists();

        if ($bentrok) {
            return back()->with('error', 'Maaf! Lapangan ini sudah dipesan pada jam tersebut. Silakan pilih jam lain.');
        }
        // 4. LOGIKA BARU: VALIDASI STOK ALAT (SEWA vs BELI)
        if ($request->has('alat')) {
            foreach ($request->alat as $alat_id => $jumlah) {
                if ($jumlah > 0) {
                    $alat = Alat::find($alat_id);

                    // JIKA BARANG SEWA (Contoh: Raket, Sepatu)
                    if ($alat->jenis_transaksi == 'Sewa') {
                        // Hitung berapa alat yang sedang dipakai orang lain di waktu yang sama
                        $terpakai = BookingAlat::join('bookings', 'booking_alats.booking_id', '=', 'bookings.id')
                            ->where('booking_alats.alat_id', $alat_id)
                            ->where('bookings.tanggal_main', $request->tanggal_main) // Hari yang sama
                            ->where('bookings.jam_mulai', '<', $jam_selesai) // Irisan waktu mulai
                            ->where('bookings.jam_selesai', '>', $jam_mulai) // Irisan waktu selesai
                            ->where('bookings.status_pembayaran', '!=', 'batal') // Abaikan pesanan batal
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

        // 5. HITUNG HARGA
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

        $total_keseluruhan = $total_harga_lapangan + $total_harga_alat;

        // 6. SIMPAN KE TABEL BOOKINGS
        $booking = Booking::create([
            'user_id' => auth::id(),
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

        // 7. KEMBALI KE DASHBOARD DENGAN PESAN SUKSES
        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat! Total tagihan Anda: Rp ' . number_format($total_keseluruhan, 0, ',', '.'));
    }
    // Fungsi baru khusus untuk membalas pertanyaan JavaScript (Kalender)
    public function cekJadwal(Request $request, Lapangan $lapangan)
    {
        $tanggal = $request->query('tanggal');

        // Cari pesanan di lapangan dan tanggal tersebut yang tidak batal
        $bookings = Booking::where('lapangan_id', $lapangan->id)
            ->where('tanggal_main', $tanggal)
            ->where('status_pembayaran', '!=', 'batal')
            ->get(['jam_mulai', 'jam_selesai']);

        $jam_terpakai = [];

        foreach ($bookings as $booking) {
            // Ambil angka jamnya saja (contoh: 08:00 jadi 8)
            $start = (int) date('H', strtotime($booking->jam_mulai));
            $end = (int) date('H', strtotime($booking->jam_selesai));

            // Masukkan jam yang terpakai ke dalam array
            for ($i = $start; $i < $end; $i++) {
                $jam_terpakai[] = $i;
            }
        }

        // Kirim balasannya dalam format JSON
        return response()->json([
            'terpakai' => $jam_terpakai
        ]);
    }
}
