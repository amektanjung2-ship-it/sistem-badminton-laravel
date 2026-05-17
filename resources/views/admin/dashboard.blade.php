<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ruang Kendali Admin ') }}
            </h2>

            <a href="{{ route('admin.laporan') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition">
                Lihat Laporan Pendapatan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 hover:shadow-md transition">
                    <div class="text-gray-500 text-sm font-semibold uppercase italic">Total Lapangan</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $total_lapangan }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500 hover:shadow-md transition">
                    <div class="text-gray-500 text-sm font-semibold uppercase italic">Total Alat Tersedia</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $total_alat }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500 hover:shadow-md transition">
                    <div class="text-gray-500 text-sm font-semibold uppercase italic">Total Transaksi</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $bookings->count() }}</div>
                </div>
            </div>

            {{-- AREA GRAFIK PENDAPATAN --}}
            <div class="mb-8">
                {{-- 1. Bagian Header & Filter --}}
                <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-5 rounded-t-xl shadow-sm border border-gray-200 border-b-0">
                    <div class="flex items-center gap-3 mb-4 sm:mb-0">
                        <div class="p-2 bg-emerald-50 rounded-lg border border-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 leading-tight">Tren Pendapatan</h3>
                            <p class="text-sm text-gray-500">Ringkasan transaksi penyewaan lapangan dan alat</p>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.dashboard') }}" class="w-full sm:w-auto">
                        <select name="periode" onchange="this.form.submit()" class="w-full sm:w-auto border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer shadow-sm hover:bg-gray-50 transition">
                            <option value="7_days" {{ $periode == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="this_month" {{ $periode == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="last_month" {{ $periode == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                        </select>
                    </form>
                </div>

                {{-- 2. Bagian Kanvas Grafik --}}
                <div class="bg-white p-5 rounded-b-xl shadow-sm border border-gray-200">
                    <canvas id="grafikPendapatan" height="80"></canvas>
                </div>
            </div>

            {{-- 3. Script untuk Menggambar Grafik --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const canvas = document.getElementById('grafikPendapatan');
                    if (!canvas) return; // Jaga-jaga agar tidak error jika canvas gagal dimuat

                    const ctx = canvas.getContext('2d');

                    // JURUS ANTI-ERROR: Menggunakan PHP murni untuk mengoper data ke JavaScript
                    const labels = <?php echo json_encode($labels); ?>;
                    const dataPendapatan = <?php echo json_encode($data); ?>;

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Pendapatan',
                                data: dataPendapatan,
                                borderColor: '#059669', // Warna Emerald
                                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.3, // Membuat garis sedikit melengkung
                                pointBackgroundColor: '#059669',
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false // Sembunyikan legenda agar lebih elegan
                                }
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <h3 class="text-lg font-bold border-b-2 border-blue-500 pb-1 inline-block"> Daftar Pesanan Masuk</h3>

                        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex w-full md:w-auto">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama pelanggan atau lapangan..."
                                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition duration-200 font-bold">
                                🔍 Cari
                            </button>
                            @if(request('search'))
                            <a href="{{ route('admin.dashboard') }}" class="ml-2 text-sm text-red-600 hover:underline flex items-center">
                                Reset
                            </a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-100">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-bold uppercase tracking-wider">Pelanggan</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold uppercase tracking-wider">Lapangan</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold uppercase tracking-wider">Jadwal Main</th>
                                    <th class="py-3 px-4 text-left text-xs font-bold uppercase tracking-wider">Tagihan</th>
                                    <th class="py-3 px-4 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-blue-50 transition duration-150">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-gray-800">{{ $booking->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->user->no_hp ?? '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 font-medium">{{ $booking->lapangan->nama_lapangan }}</td>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-800 text-sm">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500 italic">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</div>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-gray-900 text-sm">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($booking->status_pembayaran == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-1 rounded-full border border-yellow-300 uppercase">Menunggu</span>
                                        @elseif($booking->status_pembayaran == 'lunas')
                                        <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-full border border-green-300 uppercase">Lunas</span>
                                        @else
                                        <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-1 rounded-full border border-red-300 uppercase">Batal</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center flex justify-center space-x-2 mt-1">
                                        @if($booking->status_pembayaran == 'pending')
                                        <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_pembayaran" value="lunas">
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-[10px] font-bold py-1 px-2 rounded shadow transition" onclick="return confirm('Yakin ingin menandai pesanan ini sebagai LUNAS?')">
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status_pembayaran" value="batal">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold py-1 px-2 rounded shadow transition" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                Tolak
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-gray-400 text-[11px] italic font-medium">
                                            {{ $booking->status_pembayaran == 'lunas' ? '✅ Berhasil' : '❌ Selesai' }}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500 italic">Data tidak ditemukan atau belum ada pesanan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const canvasElement = document.getElementById('incomeChart');
            if (!canvasElement) return; // Mencegah error kalau canvas tidak ditemukan

            const ctx = canvasElement.getContext('2d');

            // Trik Jitu: Jadikan string dulu agar VS Code diam, lalu parse menjadi data!
            const labelData = JSON.parse('{!! json_encode($labels) !!}');
            const chartData = JSON.parse('{!! json_encode($data) !!}');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelData,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: chartData,
                        borderColor: '#10b981', // Hijau
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#10b981',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
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