<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Laporan Keuangan') }}
        </h2>
    </x-slot>

    {{-- STYLE BANNER TEMA BADMINTON MODERN --}}
    <style>
        .admin-hero {
            position: relative;
            /* Lapisan gelap (overlay) + Gambar aksi badminton resolusi tinggi */
            background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.95)), 
                              url('https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center 35%;
            background-repeat: no-repeat;
        }
    </style>

    <div class="bg-slate-100 min-h-screen pb-12">
        
        {{-- 1. HERO BANNER --}}
        <div class="admin-hero pt-16 pb-28 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-white flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div>
                    <span class="bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Ringkasan Finansial
                    </span>
                    <h1 class="text-4xl font-extrabold tracking-tight mt-3">
                        Laporan Keuangan GOR
                    </h1>
                    <p class="text-slate-300 mt-2 max-w-xl text-sm md:text-base">
                        Analisis pendapatan bersih dari penyewaan lapangan serta transaksi alat inventaris secara berkala.
                    </p>
                </div>

                {{-- KOTAK FILTER TANGGAL (Melayang Terpadu di Atas Banner) --}}
                <div class="w-full lg:w-auto bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10 shadow-2xl">
                    <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                        <div class="w-full sm:w-auto flex-1">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Dari Tanggal Main</label>
                            <input type="date" name="start_date" value="{{ $start_date }}" class="w-full sm:w-44 bg-white border-0 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-emerald-500 shadow-sm" required>
                        </div>
                        <div class="w-full sm:w-auto flex-1">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Sampai Tanggal Main</label>
                            <input type="date" name="end_date" value="{{ $end_date }}" class="w-full sm:w-44 bg-white border-0 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-emerald-500 shadow-sm" required>
                        </div>
                        <div class="w-full sm:w-auto flex gap-2">
                            <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold py-2.5 px-5 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5">
                                🔍 Filter
                            </button>
                            <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 bg-red-600 hover:bg-red-500 text-white text-sm font-bold py-2.5 px-5 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 text-center">
                                📄 PDF
                            </a>
                            @if($start_date || $end_date)
                            <a href="{{ route('admin.laporan') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center bg-gray-500 hover:bg-gray-600 text-white text-sm font-bold py-2.5 px-4 rounded-xl shadow-md transition-colors text-center">
                                Reset
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CONTAINER KONTEN UTAMA MENGAPUNG (-mt-14) --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 -mt-14 relative z-10 px-4">
            
            {{-- 2. KARTU RINGKASAN KEUANGAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Pendapatan Bersih --}}
                <div class="bg-gradient-to-br from-emerald-600 to-teal-700 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group hover:shadow-emerald-600/20 transition-all">
                    <div class="absolute right-0 top-0 opacity-15 transform translate-x-4 -translate-y-4 text-white group-hover:scale-110 transition-transform">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-emerald-100 font-bold text-xs uppercase tracking-wider mb-1 relative z-10">Total Pendapatan Bersih</h4>
                    <h2 class="text-3xl font-black relative z-10 tracking-tight">Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</h2>
                    <p class="text-[11px] text-emerald-200/80 mt-3 font-medium relative z-10">*Dari transaksi berstatus Lunas</p>
                </div>

                {{-- Pemasukan Lapangan --}}
                <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-200 flex items-center justify-between hover:border-emerald-400 transition-all">
                    <div>
                        <h4 class="text-gray-400 font-bold text-xs uppercase tracking-wider mb-1">Pemasukan Lapangan</h4>
                        <h2 class="text-2xl font-black text-gray-900">Rp {{ number_format($total_lapangan, 0, ',', '.') }}</h2>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                        </svg>
                    </div>
                </div>

                {{-- Pemasukan Sewa/Beli Alat --}}
                <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-200 flex items-center justify-between hover:border-teal-400 transition-all">
                    <div>
                        <h4 class="text-gray-400 font-bold text-xs uppercase tracking-wider mb-1">Pemasukan Sewa/Beli Alat</h4>
                        <h2 class="text-2xl font-black text-gray-900">Rp {{ number_format($total_alat, 0, ',', '.') }}</h2>
                    </div>
                    <div class="p-3 bg-teal-50 text-teal-600 rounded-xl border border-teal-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 3. TABEL DETAIL TRANSAKSI --}}
            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-200">
                <div class="p-6 border-b border-gray-100 bg-slate-50/70">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Rincian Transaksi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-gray-200">
                            <tr>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Transaksi</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal Main</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Total Tagihan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 bg-white">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="py-4 px-6 text-gray-600 font-medium">
                                    {{ $booking->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="py-4 px-6 font-bold text-gray-900 capitalize">
                                    {{ $booking->user->name }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-emerald-700">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-0.5 font-medium">
                                        {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-black text-gray-900">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-sm font-bold text-gray-500">Tidak ada transaksi lunas pada periode ini.</p>
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
</x-app-layout>