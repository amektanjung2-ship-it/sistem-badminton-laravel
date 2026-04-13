<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - Admin GOR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 text-gray-800">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Laporan Pendapatan</h1>
                <p class="text-gray-500">Rekapitulasi seluruh transaksi sukses (Lunas).</p>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow">
                ⬅️ Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 text-2xl mr-4">💰</div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Total Pendapatan Bersih</p>
                        <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 text-2xl mr-4">📝</div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Total Tiket Terjual</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalTransaksi }} Transaksi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="font-bold">Rincian Transaksi Lunas</h2>
                <button onclick="window.print()" class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-1 px-3 rounded shadow">
                    🖨️ Cetak Laporan Ini
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b-2 border-gray-200">
                            <th class="px-6 py-3 text-sm font-bold text-gray-600 uppercase">ID / Tanggal Pesan</th>
                            <th class="px-6 py-3 text-sm font-bold text-gray-600 uppercase">Pelanggan</th>
                            <th class="px-6 py-3 text-sm font-bold text-gray-600 uppercase">Jadwal Main</th>
                            <th class="px-6 py-3 text-sm font-bold text-gray-600 uppercase text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-blue-600">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold">{{ $booking->user->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <span class="font-bold">{{ $booking->lapangan->nama_lapangan }}</span><br>
                                        {{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d/m/Y') }}<br>
                                        <span class="text-gray-500">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-green-600">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada transaksi yang lunas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

</body>
</html>