<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-emerald-800 leading-tight flex items-center gap-2">
            <span class="text-3xl">🏸</span> {{ __('Dashboard Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- NOTIFIKASI SUKSES --}}
            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm mb-6 animate-pulse">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-emerald-500">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-emerald-800">Berhasil!</p>
                        <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- 🟢 SECTION: DAFTAR LAPANGAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-emerald-100">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="p-3 bg-emerald-100 rounded-xl text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-800 tracking-tight">Daftar Lapangan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($lapangans as $lapangan)
                        <div class="group border border-gray-200 rounded-2xl p-6 hover:border-emerald-400 hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-300 bg-gradient-to-b from-white to-slate-50 relative overflow-hidden flex flex-col justify-between">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-100 rounded-bl-full -mr-4 -mt-4 opacity-50 transition-transform group-hover:scale-110"></div>
                            
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-1 relative z-10">{{ $lapangan->nama_lapangan }}</h4>
                                <p class="text-emerald-600 font-semibold text-lg relative z-10">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ Jam</span></p>
                            </div>
                            
                            <a href="{{ route('booking.create', $lapangan->id) }}" class="mt-6 flex justify-center items-center gap-2 w-full text-center bg-white border-2 border-emerald-500 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white font-bold py-2.5 rounded-xl transition-all duration-300 relative z-10">
                                Pilih Jadwal
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 🏸 SECTION: SEWA PERLENGKAPAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-emerald-100">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="p-3 bg-teal-100 rounded-xl text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-800 tracking-tight">Katalog Perlengkapan</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($alats as $alat)
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-teal-300 transition bg-slate-50 relative shadow-sm hover:shadow-md">
                            <span class="absolute top-3 right-3 text-xs font-bold px-2.5 py-1 rounded-md {{ $alat->stok > 2 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                Stok: {{ $alat->stok }}
                            </span>
                            <h4 class="text-lg font-bold text-gray-800 mt-2 pr-16">{{ $alat->nama_alat }}</h4>
                            <p class="text-teal-600 font-medium">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }} / Sesi</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 🕰️ SECTION: RIWAYAT PESANAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="p-3 bg-blue-100 rounded-xl text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-800 tracking-tight">Riwayat Pesanan Saya</h3>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100">
                        <table class="min-w-full bg-white text-left">
                            <thead class="bg-slate-50 border-b border-gray-100">
                                <tr>
                                    <th class="py-4 px-5 text-sm font-bold text-gray-600">Tanggal Transaksi</th>
                                    <th class="py-4 px-5 text-sm font-bold text-gray-600">Lapangan</th>
                                    <th class="py-4 px-5 text-sm font-bold text-gray-600">Jadwal Main</th>
                                    <th class="py-4 px-5 text-sm font-bold text-gray-600">Total Tagihan</th>
                                    <th class="py-4 px-5 text-center text-sm font-bold text-gray-600">Status & Tiket</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($riwayat_bookings as $booking)
                                <tr class="hover:bg-slate-50/50 transition duration-200">
                                    <td class="py-4 px-5 text-sm text-gray-700">
                                        {{ $booking->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-5 font-bold text-gray-800">
                                        {{ $booking->lapangan->nama_lapangan }}
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</div>
                                        <div class="text-xs font-medium text-emerald-600 mt-1 bg-emerald-50 inline-block px-2 py-0.5 rounded">
                                            {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 font-bold text-gray-800">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-5 align-middle">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            @if($booking->status_pembayaran == 'pending')
                                                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full border border-amber-200">Menunggu ACC</span>
                                            @elseif($booking->status_pembayaran == 'lunas')
                                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200">Lunas</span>
                                                
                                                <div class="flex gap-2 mt-2">
                                                    <a href="{{ route('cetak.tiket', $booking->id) }}" target="_blank" class="flex items-center gap-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold py-1.5 px-3 rounded-lg shadow-sm transition">
                                                        <span>🖨️</span> Cetak
                                                    </a>
                                                    <a href="{{ route('tiket.pdf', $booking->id) }}" class="flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-1.5 px-3 rounded-lg shadow-sm transition">
                                                        <span>📥</span> PDF
                                                    </a>
                                                </div>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200">Batal</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            <p class="text-sm font-medium">Belum ada riwayat pesanan.</p>
                                            <p class="text-xs mt-1">Yuk, pilih jadwal lapangan sekarang!</p>
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