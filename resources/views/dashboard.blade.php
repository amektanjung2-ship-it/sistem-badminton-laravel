<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-emerald-600 leading-tight">
            {{ __('Dashboard Pemesanan') }}
        </h2>
    </x-slot>

    {{-- BACKGROUND THEME: Clean Light Accent dengan Emerald Highlight --}}
    <div class="py-12 min-h-screen bg-slate-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- HERO BANNER --}}
            <div data-aos="zoom-in" class="bg-gradient-to-r from-emerald-600 via-green-500 to-teal-500 rounded-2xl p-8 text-white shadow-lg shadow-emerald-100 animate-floating animate-glow">
                <h1 class="text-4xl font-bold">
                    🏸 Booking Badminton Online
                </h1>
                <p class="mt-2 text-emerald-500-100">
                    Booking lapangan lebih cepat, mudah, dan modern.
                </p>
            </div>

            {{-- WELCOME CARD --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 text-slate-600 leading-relaxed">
                    Selamat datang di dashboard pemesanan <span class="text-emerald-600 font-semibold">E-Badminton</span>! Di sini Anda dapat melihat daftar lapangan yang tersedia, menyewa perlengkapan, dan memantau riwayat pesanan Anda. Pilih jadwal lapangan favorit Anda dan nikmati pengalaman bermain badminton yang seru bersama kami!
                </div>
            </div>

            {{-- NOTIFIKASI SUKSES --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 text-emerald-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-emerald-800">Berhasil!</p>
                            <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SECTION: DAFTAR LAPANGAN --}}
            <div data-aos="fade-up" class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="p-2.5 bg-emerald-50 rounded-lg text-emerald-600 border border-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">Daftar Lapangan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($lapangans as $lapangan)
                            <div data-aos="fade-up" class="group border border-slate-200 rounded-xl p-6 shadow-md hover:border-emerald-500 hover:shadow-2xl hover:shadow-emerald-200/80 hover:-translate-y-2 transition-all duration-300 bg-white relative flex flex-col justify-between">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-800 mb-1 tracking-wide group-hover:text-emerald-600 transition-colors">{{ $lapangan->nama_lapangan }}</h4>
                                    <p class="text-emerald-600 font-semibold text-xl mt-2">
                                        Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} <span class="text-sm font-normal text-slate-400">/ Jam</span>
                                    </p>
                                </div>

                                <a href="{{ route('booking.create', $lapangan->id) }}" class="mt-6 flex justify-center items-center gap-2 w-full text-center bg-slate-50 border border-emerald-500/30 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 font-semibold py-2.5 rounded-lg transition-all duration-200 shadow-sm">
                                    Pilih Jadwal
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- SECTION: SEWA PERLENGKAPAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="p-2.5 bg-teal-50 rounded-lg text-teal-600 border border-teal-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">Katalog Perlengkapan</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($alats as $alat)
                            {{-- MODIFIKASI: Menyelaraskan bayangan, warna pendaran, dan jarak angkat (-translate-y-2) agar persis dengan kartu lapangan --}}
                            <div data-aos="fade-up" class="group border border-slate-200 rounded-xl p-6 shadow-md hover:border-emerald-500 hover:shadow-2xl hover:shadow-emerald-200/80 hover:-translate-y-2 transition-all duration-300 bg-white relative flex flex-col justify-between">
                                <span class="absolute top-4 right-4 text-xs font-semibold px-2 py-1 rounded {{ $alat->stok > 2 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                    Stok: {{ $alat->stok }}
                                </span>
                                <h4 class="text-base font-bold text-slate-700 mt-1 pr-14 tracking-wide group-hover:text-emerald-600 transition-colors">{{ $alat->nama_alat }}</h4>
                                <p class="text-teal-600 font-medium mt-2 text-lg">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }} <span class="text-xs text-slate-400 font-normal">/ Sesi</span></p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- SECTION: RIWAYAT PESANAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="p-2.5 bg-blue-50 rounded-lg text-blue-600 border border-blue-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">Riwayat Pesanan Saya</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-slate-200">
                        <table class="min-w-full bg-white text-left">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="py-3.5 px-5 text-sm font-semibold text-slate-600 tracking-wide">Tanggal Transaksi</th>
                                    <th class="py-3.5 px-5 text-sm font-semibold text-slate-600 tracking-wide">Lapangan</th>
                                    <th class="py-3.5 px-5 text-sm font-semibold text-slate-600 tracking-wide">Jadwal Main</th>
                                    <th class="py-3.5 px-5 text-sm font-semibold text-slate-600 tracking-wide">Total Tagihan</th>
                                    <th class="py-3.5 px-5 text-center text-sm font-semibold text-slate-600 tracking-wide">Status & Tiket</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($riwayat_bookings as $booking)
                                    <tr class="hover:bg-slate-50 transition duration-150">
                                        <td class="py-4 px-5 text-sm text-slate-600">
                                            {{ $booking->created_at->format('d M Y') }}
                                        </td>
                                        <td class="py-4 px-5 text-sm font-bold text-slate-800 tracking-wide">
                                            {{ $booking->lapangan->nama_lapangan }}
                                        </td>
                                        <td class="py-4 px-5">
                                            <div class="text-sm font-semibold text-slate-700">
                                                {{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}
                                            </div>
                                            <div class="text-xs font-medium text-emerald-700 mt-1 bg-emerald-50 inline-block px-2 py-0.5 rounded border border-emerald-200">
                                                {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-5 text-sm font-bold text-emerald-600">
                                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-5 align-middle">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                @if($booking->status_pembayaran == 'pending')
                                                    <span class="bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full border border-amber-200">Menunggu ACC</span>
                                                @elseif($booking->status_pembayaran == 'lunas')
                                                    <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full border border-emerald-200">Lunas</span>
                                                    <div class="mt-1.5">
                                                        <a href="{{ route('cetak.tiket', $booking->id) }}" target="_blank" class="flex items-center gap-1.5 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-semibold py-1.5 px-3 rounded-md shadow-sm transition">
                                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                            </svg>
                                                            Cetak
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="bg-red-50 text-red-700 text-xs font-semibold px-3 py-1 rounded-full border border-red-200">Batal</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-slate-500">Belum ada riwayat pesanan.</p>
                                                <p class="text-xs mt-1 text-slate-400">Yuk, pilih jadwal lapangan sekarang!</p>
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