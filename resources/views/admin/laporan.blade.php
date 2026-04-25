<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-emerald-800 leading-tight flex items-center gap-2">
            <span class="text-3xl">📊</span> Laporan Keuangan GOR
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. KOTAK FILTER TANGGAL --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-2xl border border-emerald-100">
                <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                    <div class="w-full sm:w-auto flex-1">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Dari Tanggal Main</label>
                        <input type="date" name="start_date" value="{{ $start_date }}" class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>
                    <div class="w-full sm:w-auto flex-1">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Sampai Tanggal Main</label>
                        <input type="date" name="end_date" value="{{ $end_date }}" class="w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>
                    <div class="w-full sm:w-auto flex gap-2">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-lg shadow transition w-full sm:w-auto">
                            🔍 Filter
                        </button>
                        <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg shadow transition text-center">
                            📄 Ekspor PDF
                        </a>
                        @if($start_date || $end_date)
                        <a href="{{ route('admin.laporan') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2.5 px-6 rounded-lg shadow transition w-full sm:w-auto text-center">
                            Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- 2. KARTU RINGKASAN KEUANGAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-20 transform translate-x-4 -translate-y-4">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-emerald-100 font-medium text-lg mb-1 relative z-10">Total Pendapatan Bersih</h4>
                    <h2 class="text-3xl font-extrabold relative z-10">Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</h2>
                    <p class="text-sm text-emerald-100 mt-2 relative z-10">*Dari transaksi berstatus Lunas</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <h4 class="text-gray-500 font-medium text-sm mb-1">Pemasukan Lapangan</h4>
                        <h2 class="text-2xl font-bold text-gray-800">Rp {{ number_format($total_lapangan, 0, ',', '.') }}</h2>
                    </div>
                    <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600">🏸</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <h4 class="text-gray-500 font-medium text-sm mb-1">Pemasukan Sewa/Beli Alat</h4>
                        <h2 class="text-2xl font-bold text-gray-800">Rp {{ number_format($total_alat, 0, ',', '.') }}</h2>
                    </div>
                    <div class="p-4 bg-teal-50 rounded-xl text-teal-600">👟</div>
                </div>
            </div>

            {{-- 3. TABEL DETAIL TRANSAKSI --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Rincian Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">
                            <thead class="bg-slate-50 text-gray-600 text-sm">
                                <tr>
                                    <th class="py-3 px-4 border-b font-semibold">Tgl Transaksi</th>
                                    <th class="py-3 px-4 border-b font-semibold">Pelanggan</th>
                                    <th class="py-3 px-4 border-b font-semibold">Jadwal Main</th>
                                    <th class="py-3 px-4 border-b font-semibold">Total Tagihan</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-gray-600">{{ $booking->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-3 px-4 font-bold text-gray-800">{{ $booking->user->name }}</td>
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-emerald-700">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</div>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-gray-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400 italic">Tidak ada transaksi lunas pada periode ini.</td>
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