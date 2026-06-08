<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-emerald-800 leading-tight">
            {{ __('Dasbor Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- NOTIFIKASI SISTEM --}}
            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-6 flex items-start">
                <div class="flex-shrink-0 text-emerald-500 mt-0.5">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-800">Pemberitahuan</p>
                    <p class="text-sm font-medium text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            {{-- KARTU STATUS KEANGGOTAAN --}}
            @if(auth()->user()->is_member)
            {{-- SUDAH VIP --}}
            <div class="bg-gradient-to-r from-amber-400 to-yellow-500 rounded-2xl shadow-md p-6 text-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-white/20 rounded-xl p-3 flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-yellow-100">Status Keanggotaan</p>
                            <p class="text-2xl font-extrabold tracking-tight mt-0.5">Member VIP Aktif</p>
                            <p class="text-sm text-yellow-100 mt-1">Selamat! Anda menikmati diskon <span class="font-extrabold text-white">10%</span> untuk setiap transaksi.</p>
                        </div>
                    </div>
                    <div class="bg-white/20 border border-white/30 rounded-xl px-5 py-3 text-center flex-shrink-0">
                        <p class="text-xs font-bold text-yellow-100 uppercase tracking-wide">Total Transaksi</p>
                        <p class="text-3xl font-extrabold mt-0.5">{{ $totalTransaksiLunas }}x</p>
                    </div>
                </div>
            </div>

            @else
            {{-- BELUM VIP: TAMPILKAN PROGRESS BAR --}}

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="bg-amber-50 rounded-xl p-2.5 border border-amber-100">
                        <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-extrabold text-gray-900 text-base">Kemajuan Menuju Member VIP</p>
                        <p class="text-xs text-gray-500 mt-0.5">Penuhi salah satu syarat di bawah untuk mendapatkan diskon <span class="font-bold text-amber-600">10%</span> selamanya.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- PROGRESS: JUMLAH TRANSAKSI --}}
                    <div class="bg-slate-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Jumlah Transaksi</p>
                            <span class="text-xs font-extrabold {{ $totalTransaksiLunas >= $targetTransaksi ? 'text-emerald-600' : 'text-gray-700' }}">
                                {{ $totalTransaksiLunas }} / {{ $targetTransaksi }}x
                            </span>
                        </div>
                        <meter value="{{ $pctTransaksi }}" min="0" max="100"
                            class="w-full h-3 rounded-full"
                            title="{{ $pctTransaksi }}%"></meter>
                        <p class="text-[11px] text-gray-500 mt-2">
                            @if($sisaTransaksi > 0)
                                Kurang <span class="font-bold text-gray-700">{{ $sisaTransaksi }}x</span> transaksi lagi
                            @else
                                <span class="font-bold text-emerald-600">✓ Syarat terpenuhi!</span>
                            @endif
                        </p>
                    </div>

                    {{-- PROGRESS: TOTAL PENGELUARAN --}}
                    <div class="bg-slate-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Total Pengeluaran</p>
                            <span class="text-xs font-extrabold {{ $totalPengeluaranLunas >= $targetPengeluaran ? 'text-emerald-600' : 'text-gray-700' }}">
                                Rp {{ number_format($totalPengeluaranLunas, 0, ',', '.') }}
                            </span>
                        </div>
                        <meter value="{{ $pctPengeluaran }}" min="0" max="100"
                            class="w-full h-3 rounded-full"
                            title="{{ $pctPengeluaran }}%"></meter>
                        <p class="text-[11px] text-gray-500 mt-2">
                            @if($sisaPengeluaran > 0)
                                Kurang <span class="font-bold text-gray-700">Rp {{ number_format($sisaPengeluaran, 0, ',', '.') }}</span> lagi
                            @else
                                <span class="font-bold text-emerald-600">✓ Syarat terpenuhi!</span>
                            @endif
                        </p>
                    </div>

                </div>
            </div>
            @endif

            {{-- BAGIAN: KATALOG LAPANGAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="p-2.5 bg-emerald-50 rounded-lg text-emerald-600 border border-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 tracking-tight">Fasilitas Lapangan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($lapangans as $lapangan)
                        <div class="group border border-gray-200 rounded-xl p-6 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 bg-white relative flex flex-col justify-between overflow-hidden">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $lapangan->nama_lapangan }}</h4>
                                <p class="text-emerald-700 font-extrabold text-xl mt-2">
                                    Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">/ Jam</span>
                                </p>
                            </div>

                            <a href="{{ route('booking.create', $lapangan->id) }}" class="mt-8 flex justify-center items-center gap-2 w-full text-center bg-white border-2 border-emerald-600 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white font-bold py-2.5 rounded-lg transition-all duration-300 shadow-sm">
                                Lakukan Pemesanan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- BAGIAN: INFORMASI INVENTARIS TAMBAHAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="p-2.5 bg-teal-50 rounded-lg text-teal-600 border border-teal-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 tracking-tight">Katalog Inventaris Tambahan</h3>
                            <p class="text-sm text-gray-500 mt-1">Perlengkapan yang dapat disewa saat melakukan pemesanan lapangan.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($alats as $alat)
                        <div class="border border-gray-200 rounded-xl p-5 hover:border-teal-400 transition-colors bg-slate-50 relative flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-sm font-bold text-gray-800 pr-2">{{ $alat->nama_alat }}</h4>
                                    <span class="text-[10px] font-bold uppercase tracking-wide px-2 py-1 rounded-full {{ $alat->stok > 2 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        Tersedia: {{ $alat->stok }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-teal-700 font-bold mt-3">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }} <span class="text-xs font-medium text-gray-500">/ Item</span></p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- BAGIAN: RIWAYAT TRANSAKSI --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="p-2.5 bg-blue-50 rounded-lg text-blue-600 border border-blue-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 tracking-tight">Riwayat Transaksi</h3>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full bg-white text-left">
                            <thead class="bg-slate-50 border-b border-gray-200">
                                <tr>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal Transaksi</th>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider">Fasilitas</th>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider">Jadwal Pemakaian</th>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider">Total Tagihan</th>
                                    <th class="py-4 px-5 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status Dokumen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($riwayat_bookings as $booking)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="py-4 px-5 text-sm text-gray-700 font-medium">
                                        {{ $booking->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-5 text-sm font-bold text-gray-900">
                                        {{ $booking->lapangan->nama_lapangan }}
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</div>
                                        <div class="text-xs font-bold text-emerald-700 mt-1.5 bg-emerald-50 inline-block px-2.5 py-1 rounded-md border border-emerald-100 tracking-wide">
                                            {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 text-sm font-extrabold text-gray-900">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-5 align-middle">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            @if($booking->status_pembayaran == 'pending')
                                                <span class="bg-amber-100 text-amber-800 text-[11px] font-bold px-3 py-1 rounded-full border border-amber-200 uppercase tracking-wide">Menunggu Verifikasi</span>
                                                <div class="mt-2">
                                                    <form action="{{ route('booking.batalkan', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini? Tindakan ini tidak dapat diurungkan.')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="flex items-center justify-center gap-1.5 bg-white border border-red-400 hover:bg-red-600 hover:text-white hover:border-red-600 text-red-600 text-xs font-bold py-1.5 px-4 rounded-lg shadow-sm transition-all duration-200">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($booking->status_pembayaran == 'lunas')
                                                <span class="bg-emerald-100 text-emerald-800 text-[11px] font-bold px-3 py-1 rounded-full border border-emerald-200 uppercase tracking-wide">Lunas</span>
                                                <div class="mt-1">
                                                    <a href="{{ route('cetak.tiket', $booking->id) }}" target="_blank" class="flex items-center justify-center gap-1.5 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold py-1.5 px-4 rounded-lg shadow-sm transition-colors">
                                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                        </svg>
                                                        Cetak Tiket
                                                    </a>
                                                </div>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-[11px] font-bold px-3 py-1 rounded-full border border-red-200 uppercase tracking-wide">Dibatalkan</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <p class="text-base font-bold text-gray-500 mb-1">Riwayat Transaksi Kosong</p>
                                            <p class="text-sm text-gray-400">Silakan lakukan pemesanan fasilitas melalui katalog di atas.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>