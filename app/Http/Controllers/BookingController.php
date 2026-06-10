<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Booking;
use App\Models\BookingAlat;
use App\Models\Lapangan;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // WAJIB DITAMBAHKAN UNTUK TRANSAKSI DATABASE
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected $whatsappService;

    // Constructor untuk menyuntikkan WhatsAppService ke Controller
    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function create(Lapangan $lapangan)
    {
        if (! $lapangan->status_aktif) {
            return redirect()->route('dashboard')->with('error', 'Maaf, lapangan ini sedang tidak aktif.');
        }

        $alats = Alat::where('stok', '>', 0)->get();
        return view('booking.create', compact('lapangan', 'alats'));
    }

    // =====================================================================================
    // FUNGSI UTAMA (SUDAH DIGABUNG DENGAN NOTIFIKASI EMAIL DAN WHATSAPP)
    // =====================================================================================
    public function store(Request $request, Lapangan $lapangan)
    {
        if (! $lapangan->status_aktif) {
            return redirect()->route('dashboard')->with('error', 'Maaf, lapangan ini sedang tidak aktif.');
        }

        // 1. Validasi input
        $request->validate([
            'tanggal_main' => 'required|date|after_or_equal:today',
            'jam_mulai'    => 'required',
            'nama_pemesan' => 'nullable|string|max:255',
            'durasi'       => 'required|numeric|min:1|max:10', // Diubah minimal 1 jam sesuai UI baru
        ], [
            'tanggal_main.after_or_equal' => 'Tidak bisa memesan untuk hari yang sudah lewat!',
            'durasi.min'                  => 'Durasi minimal 1 jam.',
            'durasi.max'                  => 'Durasi maksimal 10 jam.',
        ]);

        // 2. Validasi jam mulai dalam operasional (08:00 - 22:00)
        $jam_mulai_int = (int) date('H', strtotime($request->jam_mulai));
        if ($jam_mulai_int < 8 || $jam_mulai_int >= 23) {
            return back()->with('error', 'Jam mulai harus antara 08:00 hingga 22:00.');
        }

        // 3. Validasi tidak bisa booking jam yang sudah lewat hari ini
        if ($request->tanggal_main == date('Y-m-d')) {
            if ($request->jam_mulai <= date('H:i')) {
                return back()->with('error', 'Waktu tersebut sudah berlalu! Silakan pilih jam yang belum terlewat.');
            }
        }

        // 4. Hitung jam selesai
        $jam_mulai       = $request->jam_mulai;
        $durasi          = (int) $request->durasi;
        $baseDate        = '2000-01-01';
        $jamMulaiTs      = strtotime("{$baseDate} {$jam_mulai}");
        $jamSelesaiTs    = $jamMulaiTs + ($durasi * 3600);
        $jam_selesai     = date('H:i', $jamSelesaiTs);
        $jamSelesaiInt   = (int) date('H', $jamSelesaiTs);
        $menitSelesaiInt = (int) date('i', $jamSelesaiTs);

        // 5. Validasi jam selesai tidak melebihi 23:00
        $batasSelesaiTs = strtotime("{$baseDate} 23:00");
        if ($jamSelesaiTs > $batasSelesaiTs || ($jamSelesaiInt === 23 && $menitSelesaiInt > 0)) {
            $maksimalDurasi = (int) floor(($batasSelesaiTs - $jamMulaiTs) / 3600);
            return back()->with('error', "Jadwal melebihi jam operasional. Untuk jam mulai {$jam_mulai}, durasi maksimal adalah {$maksimalDurasi} jam (selesai pukul 23:00).");
        }

        DB::beginTransaction();

        try {
            $lapanganLocked = Lapangan::where('id', $lapangan->id)->lockForUpdate()->first();

            // 6. Cek bentrok jadwal
            $bentrok = Booking::where('lapangan_id', $lapanganLocked->id)
                ->where('tanggal_main', $request->tanggal_main)
                ->where('status_pembayaran', '!=', 'batal')
                ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                    $query->where('jam_mulai', '<', $jam_selesai)
                        ->where('jam_selesai', '>', $jam_mulai);
                })->exists();

            if ($bentrok) {
                DB::rollBack();
                return back()->with('error', 'Maaf! Lapangan sudah dipesan pada jam tersebut. Silakan pilih jam lain.');
            }

            // 7. Validasi stok alat
            if ($request->has('alat')) {
                foreach ($request->alat as $alat_id => $jumlah) {
                    $jumlah = (int) $jumlah;
                    if ($jumlah <= 0) {
                        continue;
                    }

                    $alat = Alat::where('id', $alat_id)->lockForUpdate()->first();
                    if (! $alat) {
                        continue;
                    }

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
                            DB::rollBack();
                            return back()->with('error', "Sisa stok {$alat->nama_alat} di jam tersebut hanya {$sisa_stok}.");
                        }
                    } else {
                        if ($jumlah > $alat->stok) {
                            DB::rollBack();
                            return back()->with('error', "Stok {$alat->nama_alat} tidak mencukupi. Sisa: {$alat->stok}");
                        }
                    }
                }
            }

            // 8. Hitung total harga
            $total_harga_lapangan = $lapanganLocked->harga_per_jam * $request->durasi;
            $total_harga_alat     = 0;

            if ($request->has('alat')) {
                foreach ($request->alat as $alat_id => $jumlah) {
                    $jumlah = (int) $jumlah;
                    if ($jumlah <= 0) {
                        continue;
                    }

                    $alat              = Alat::find($alat_id);
                    $total_harga_alat += $alat->harga_sewa * $jumlah;
                }
            }

            $total = $total_harga_lapangan + $total_harga_alat;

            // 9. Diskon member 10%
            if (Auth::user()->is_member) {
                $total = $total - ($total * 0.10);
            }

            // 10. Simpan booking ke pangkalan data
            $booking = Booking::create([
                'user_id'           => Auth::id(),
                'lapangan_id'       => $lapanganLocked->id,
                'nama_pemesan'      => $request->input('nama_pemesan'),
                'tanggal_main'      => $request->tanggal_main,
                'jam_mulai'         => $jam_mulai,
                'jam_selesai'       => $jam_selesai,
                'total_harga'       => round($total),
                'status_pembayaran' => 'pending',
            ]);

            // 11. Simpan booking alat & kurangi stok
            if ($request->has('alat')) {
                foreach ($request->alat as $alat_id => $jumlah) {
                    $jumlah = (int) $jumlah;
                    if ($jumlah <= 0) {
                        continue;
                    }

                    $alat = Alat::find($alat_id);

                    BookingAlat::create([
                        'booking_id' => $booking->id,
                        'alat_id'    => $alat_id,
                        'jumlah'     => $jumlah,
                        'subtotal'   => $alat->harga_sewa * $jumlah,
                    ]);

                    if ($alat->jenis_transaksi == 'Beli') {
                        $alat->decrement('stok', $jumlah);
                    }
                }
            }

            // 12. Tutup Transaksi dan Permanenkan Data
            DB::commit();

            // =====================================================================
            // 1. OTOMATIS KIRIM EMAIL KE PELANGGAN
            // =====================================================================
            try {
                if (!empty($booking->user->email)) {
                    \Illuminate\Support\Facades\Mail::to($booking->user->email)->send(new \App\Mail\BookingSuccessMail($booking));
                }
            } catch (\Exception $e) {
                // Log error jika email gagal dikirim agar aplikasi utama tidak ikut crash
                \Illuminate\Support\Facades\Log::error('Gagal kirim email booking: ' . $e->getMessage());
            }

            // =====================================================================
            // 2. OTOMATIS KIRIM WHATSAPP KE PELANGGAN via FONNTE
            // =====================================================================
            try {
                $nomorTujuan = $booking->user->no_hp; // Menggunakan kolom 'no_hp' yang sinkron dengan data registrasi Anda
                if (!empty($nomorTujuan)) {
                    $totalBayarFormatted = number_format($booking->total_harga, 0, ',', '.');
                    $namaLapangan        = $lapanganLocked->nama_lapangan;

                    $pesanWa = "Halo *" . ($booking->nama_pemesan ?? $booking->user->name) . "*, booking lapangan berhasil! 🏸\n\n" .
                               "Detail Rincian Booking:\n" .
                               "▪️ Lapangan: " . $namaLapangan . "\n" .
                               "▪️ Tanggal: " . $booking->tanggal_main . "\n" .
                               "▪️ Jadwal Jam: " . $booking->jam_mulai . " s/d " . $booking->jam_selesai . " (" . $request->durasi . " Jam)\n" .
                               "▪️ Total Bayar: Rp " . $totalBayarFormatted . "\n\n" .
                               "Status booking Anda saat ini adalah *Pending* (Menunggu Verifikasi Pembayaran Admin). Terima kasih!";
                               
                    // Panggil Whatsapp Service untuk menembak API Gateway Fonnte
                    $this->whatsappService->sendMessage($nomorTujuan, $pesanWa);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal kirim WA booking: ' . $e->getMessage());
            }

            $pesan_diskon = Auth::user()->is_member ? ' (sudah termasuk diskon member 10%)' : '';
            return redirect()->route('dashboard')
                ->with('success', "Booking berhasil! Total: Rp " . number_format($total, 0, ',', '.') . $pesan_diskon . ". Rincian telah dikirim ke WhatsApp.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kendala pada server saat memproses pesanan Anda. Silakan coba beberapa saat lagi.');
        }
    }

    // API untuk kalender jadwal
    public function cekJadwal(Request $request, Lapangan $lapangan)
    {
        $tanggal  = $request->query('tanggal');
        $bookings = Booking::where('lapangan_id', $lapangan->id)
            ->where('tanggal_main', $tanggal)
            ->where('status_pembayaran', '!=', 'batal')
            ->get(['jam_mulai', 'jam_selesai']);

        $terpakai = $bookings->map(fn($b) => [
            'start' => $b->jam_mulai,
            'end'   => $b->jam_selesai,
        ]);

        return response()->json(['terpakai' => $terpakai]);
    }

    // Pembatalan Booking oleh Pelanggan
    public function batalkan(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak membatalkan booking ini.');
        }

        if ($booking->status_pembayaran !== 'pending') {
            return redirect()->route('dashboard')
                ->with('error', 'Hanya booking dengan status Menunggu Verifikasi yang dapat dibatalkan.');
        }

        foreach ($booking->bookingAlats as $item) {
            $alat = Alat::find($item->alat_id);
            if ($alat && strtolower($alat->jenis_transaksi) == 'beli') {
                $alat->increment('stok', $item->jumlah);
            }
        }

        $booking->update(['status_pembayaran' => 'batal']);

        return redirect()->route('dashboard')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}