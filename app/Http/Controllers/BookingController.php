<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Alat;
use App\Models\Booking;
use App\Models\BookingAlat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // WAJIB DITAMBAHKAN UNTUK TRANSAKSI DATABASE

class BookingController extends Controller
{
    public function create(Lapangan $lapangan)
    {
        if (!$lapangan->status_aktif) {
            return redirect()->route('dashboard')->with('error', 'Maaf, lapangan ini sedang tidak aktif.');
        }

        $alats = Alat::where('stok', '>', 0)->get();
        return view('booking.create', compact('lapangan', 'alats'));
    }

    public function store(Request $request, Lapangan $lapangan)
    {
        if (!$lapangan->status_aktif) {
            return redirect()->route('dashboard')->with('error', 'Maaf, lapangan ini sedang tidak aktif.');
        }

        // 1. Validasi input
        $request->validate([
            'tanggal_main' => 'required|date|after_or_equal:today',
            'jam_mulai'    => 'required',
            'durasi'       => 'required|numeric|min:1|max:10', // Diubah minimal 1 jam sesuai UI baru
        ], [
            'tanggal_main.after_or_equal' => 'Tidak bisa memesan untuk hari yang sudah lewat!',
            'durasi.min'                  => 'Durasi minimal 1 jam.',
            'durasi.max'                  => 'Durasi maksimal 10 jam.',
        ]);

        // 2. Validasi jam operasional
        $jam_cek = (int) date('H', strtotime($request->jam_mulai));
        if ($jam_cek < 8 || $jam_cek >= 23) {
            return back()->with('error', 'GOR hanya beroperasi antara jam 08:00 hingga 23:00.');
        }

        // 3. Validasi tidak bisa booking jam yang sudah lewat hari ini
        date_default_timezone_set('Asia/Jakarta');
        if ($request->tanggal_main == date('Y-m-d')) {
            if ($request->jam_mulai <= date('H:i')) {
                return back()->with('error', 'Waktu tersebut sudah berlalu! Silakan pilih jam yang belum terlewat.');
            }
        }

        // 4. Hitung jam selesai
        $jam_mulai   = $request->jam_mulai;
        $menit       = $request->durasi * 60;
        $jam_selesai = date('H:i', strtotime($jam_mulai . " + {$menit} minutes"));

        // 5. Validasi jam selesai tidak melebihi jam operasional
        $jam_selesai_int   = (int) date('H', strtotime($jam_selesai));
        $menit_selesai_int = (int) date('i', strtotime($jam_selesai));
        if ($jam_selesai_int > 23 || ($jam_selesai_int == 23 && $menit_selesai_int > 0)) {
            return back()->with('error', 'Jadwal melebihi jam operasional. Maksimal selesai pukul 23:00.');
        }

        // =====================================================================================
        // MEMULAI ZONA AMAN (TRANSAKSI DATABASE & PESSIMISTIC LOCKING)
        // =====================================================================================
        DB::beginTransaction();

        try {
            // [KUNCI KEAMANAN]: Mengunci baris Lapangan ini di database. 
            // Jika ada orang lain yang menekan tombol di milidetik yang sama, mereka harus antre di baris kode ini.
            $lapanganLocked = Lapangan::where('id', $lapangan->id)->lockForUpdate()->first();

            // 6. Cek bentrok jadwal (Sekarang kebal dari serangan pemesanan bersamaan / Race Condition)
            $bentrok = Booking::where('lapangan_id', $lapanganLocked->id)
                ->where('tanggal_main', $request->tanggal_main)
                ->where('status_pembayaran', '!=', 'batal')
                ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                    $query->where('jam_mulai', '<', $jam_selesai)
                        ->where('jam_selesai', '>', $jam_mulai);
                })->exists();

            if ($bentrok) {
                DB::rollBack(); // Batalkan antrean kunci
                return back()->with('error', 'Maaf! Lapangan sudah dipesan pada jam tersebut. Silakan pilih jam lain.');
            }

            // 7. Validasi stok alat
            if ($request->has('alat')) {
                foreach ($request->alat as $alat_id => $jumlah) {
                    $jumlah = (int) $jumlah;
                    if ($jumlah <= 0) continue;

                    // Kita juga kunci data alatnya agar tidak ada yang menyewa barang yang sama bersamaan
                    $alat = Alat::where('id', $alat_id)->lockForUpdate()->first();
                    if (!$alat) continue;

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
                    if ($jumlah <= 0) continue;
                    $alat = Alat::find($alat_id);
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
                    if ($jumlah <= 0) continue;

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

            // 12. Tutup Transaksi dan Permanenkan Data (Pelepasan Kunci)
            DB::commit();

            $pesan_diskon = Auth::user()->is_member ? ' (sudah termasuk diskon member 10%)' : '';
            return redirect()->route('dashboard')
                ->with('success', "Booking berhasil! Total: Rp " . number_format($total, 0, ',', '.') . $pesan_diskon . ". Menunggu konfirmasi admin.");

        } catch (\Exception $e) {
            DB::rollBack(); // Jika terjadi sistem error (mati lampu, server down), batalkan semua!
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
}