<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dasbor Utama Admin') }}
        </h2>
    </x-slot>

    {{-- STYLE BANNER DENGAN BACKGROUND ORANG BERMAIN BADMINTON --}}
    <style>
        .admin-hero {
            position: relative;
            /* Lapisan gelap (overlay) + Gambar aksi badminton resolusi tinggi */
            background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.95)), 
                              url('https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center 35%; /* Mengatur fokus gambar agar pemain terlihat pas */
            background-repeat: no-repeat;
        }
    </style>

    <div class="bg-slate-100 min-h-screen pb-12">
        
        {{-- 1. HERO BANNER DENGAN PRESET Latar Belakang Olahraga --}}
        <div class="admin-hero pt-16 pb-28 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div>
                    <span class="bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Panel Kendali Utama
                    </span>
                    <h1 class="text-4xl font-extrabold tracking-tight mt-3">
                        Ruang Kendali Admin
                    </h1>
                    <p class="text-slate-300 mt-2 max-w-xl text-sm md:text-base">
                        Pantau statistik pemesanan, kelola ketersediaan fasilitas lapangan, dan verifikasi transaksi masuk secara langsung.
                    </p>
                </div>
                {{-- Tombol Laporan --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.laporan') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold py-3 px-5 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat Laporan Pendapatan
                    </a>
                </div>
            </div>
        </div>

        {{-- CONTAINER KONTEN YANG MENGAPUNG (-mt-14) --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 -mt-14 relative z-10 px-4">
            
            {{-- 2. NOTIFIKASI BERHASIL --}}
            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-2xl shadow-md flex items-start">
                <div class="flex-shrink-0 text-emerald-500 mt-0.5">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-800">Berhasil!</p>
                    <p class="text-sm font-medium text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            {{-- 3. KOTAK STATISTIK (FLOATING CARDS) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card 1: Total Lapangan --}}
                <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 flex items-center gap-4 hover:border-emerald-400 transition-all hover:shadow-lg">
                    <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Total Lapangan</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $total_lapangan }}</h4>
                    </div>
                </div>

                {{-- Card 2: Kapasitas Alat --}}
                <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 flex items-center gap-4 hover:border-teal-400 transition-all hover:shadow-lg">
                    <div class="p-4 bg-teal-50 text-teal-600 rounded-xl border border-teal-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Kapasitas Alat</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $total_alat }}</h4>
                    </div>
                </div>

                {{-- Card 3: Total Transaksi --}}
                <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 flex items-center gap-4 hover:border-blue-400 transition-all hover:shadow-lg">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-xl border border-blue-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Total Transaksi</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ count($bookings) }}</h4>
                    </div>
                </div>
            </div>

            {{-- 4. AREA GRAFIK PENDAPATAN --}}
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/70">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-100 text-emerald-700 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900 tracking-tight text-base">Tren Pendapatan</h3>
                    </div>
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="w-full sm:w-auto">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <select name="periode" onchange="this.form.submit()" class="w-full sm:w-auto border-gray-200 rounded-xl text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500 shadow-sm cursor-pointer hover:bg-gray-50">
                            <option value="7_days" {{ $periode == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="this_month" {{ $periode == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="last_month" {{ $periode == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                        </select>
                    </form>
                </div>
                <div class="p-6">
                    <canvas id="grafikPendapatan" height="90"></canvas>
                </div>
            </div>

            {{-- 5. TABEL DAFTAR PESANAN MASUK (TETAP DIKEEPMANEN) --}}
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/70">
                    <h3 class="font-bold text-lg text-gray-900 tracking-tight">Manajemen Pesanan Masuk</h3>
                    
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-2">
                        @if(request('periode'))
                            <input type="hidden" name="periode" value="{{ request('periode') }}">
                        @endif
                        
                        <div class="flex w-full shadow-sm rounded-xl">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelanggan..." class="w-full sm:w-64 border-gray-300 rounded-l-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 border border-emerald-600 rounded-r-xl text-sm font-bold transition-colors">
                                Cari
                            </button>
                        </div>
                        
                        @if(request('search'))
                        <a href="{{ route('admin.dashboard') }}" class="text-xs text-red-500 hover:text-red-700 font-bold ml-2">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white text-left">
                        <thead class="bg-slate-50 border-b border-gray-200">
                            <tr>
                                <th class="py-4 px-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="py-4 px-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Fasilitas</th>
                                <th class="py-4 px-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal Main</th>
                                <th class="py-4 px-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Tagihan</th>
                                <th class="py-4 px-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi Validasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="py-4 px-5">
                                    <div class="font-bold text-gray-900 text-sm">{{ $booking->user?->name ?? 'Pengguna Terhapus' }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $booking->user?->email ?? '-' }}</div>
                                    @if($booking->nama_pemesan)
                                    <div class="text-xs text-gray-500 mt-2">
                                        <span class="font-semibold text-gray-600">Nama Pesanan:</span>
                                        <span>{{ $booking->nama_pemesan }}</span>
                                    </div>
                                    @endif
                                </td>
                                <td class="py-4 px-5 font-bold text-sm text-gray-800">
                                    {{ $booking->lapangan?->nama_lapangan ?? 'Fasilitas Terhapus' }}
                                </td>
                                <td class="py-4 px-5">
                                    <div class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</div>
                                    <div class="text-[11px] font-bold text-emerald-700 mt-1.5 bg-emerald-50 inline-block px-2.5 py-1 rounded-md border border-emerald-100 tracking-wide">
                                        {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-sm font-extrabold text-gray-900">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-5 align-middle">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        @if(strtolower($booking->status_pembayaran) == 'pending')
                                            <span class="bg-amber-50 text-amber-800 text-[10px] font-bold px-3 py-1 rounded-full border border-amber-200 uppercase tracking-widest">Menunggu ACC</span>
                                            
                                            <div class="flex items-center gap-2 mt-1">
                                                <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_pembayaran" value="lunas">
                                                    <button type="submit" class="flex items-center justify-center bg-white hover:bg-emerald-50 text-emerald-600 border border-emerald-200 hover:border-emerald-400 p-2 rounded-lg transition-colors shadow-sm" title="Terima Pesanan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_pembayaran" value="batal">
                                                    <button type="submit" class="flex items-center justify-center bg-white hover:bg-red-50 text-red-600 border border-red-200 hover:border-red-400 p-2 rounded-lg transition-colors shadow-sm" title="Tolak Pesanan" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif(strtolower($booking->status_pembayaran) == 'lunas')
                                            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-3 py-1.5 rounded-full border border-emerald-200 uppercase tracking-widest">Telah Dilunasi</span>
                                        @else
                                            <span class="bg-red-50 text-red-800 text-[10px] font-bold px-3 py-1.5 rounded-full border border-red-200 uppercase tracking-widest">Dibatalkan</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <p class="text-sm font-bold text-gray-500">Antrean Kosong</p>
                                        <p class="text-xs mt-1 text-gray-400">Belum ada pesanan masuk yang perlu diproses.</p>
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

    {{-- SCRIPT GRAFIK CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('grafikPendapatan');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const labels = @json($labels);
            const dataPendapatan = @json($data);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Pendapatan (Rp)',
                        data: dataPendapatan,
                        borderColor: '#059669',
                        backgroundColor: 'rgba(5, 150, 105, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35, 
                        pointBackgroundColor: '#059669',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>