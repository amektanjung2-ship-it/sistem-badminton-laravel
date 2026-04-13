<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ruang Kendali Admin') }}
            </h2>
            
            <a href="{{ route('admin.laporan') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition">
                📊 Lihat Laporan Pendapatan
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Lapangan</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $total_lapangan }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Alat Tersedia</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $total_alat }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Transaksi</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $bookings->count() }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">📋 Daftar Pesanan Masuk</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Pelanggan</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Lapangan</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Jadwal Main</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Total Tagihan</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Status</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 border-b">
                                        <div class="font-semibold text-gray-800">{{ $booking->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->user->no_hp ?? '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4 border-b text-gray-700">{{ $booking->lapangan->nama_lapangan }}</td>
                                    <td class="py-3 px-4 border-b">
                                        <div class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</div>
                                    </td>
                                    <td class="py-3 px-4 border-b font-semibold text-gray-800">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 border-b text-center">
                                        @if($booking->status_pembayaran == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-300">Menunggu</span>
                                        @elseif($booking->status_pembayaran == 'lunas')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-300">Lunas</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-300">Batal</span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-3 px-4 border-b text-center flex justify-center space-x-2">
                                        @if($booking->status_pembayaran == 'pending')
                                            <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status_pembayaran" value="lunas">
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-2 rounded transition" onclick="return confirm('Yakin ingin menandai pesanan ini sebagai LUNAS?')">
                                                    Lunas
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status_pembayaran" value="batal">
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-2 rounded transition" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                    Batal
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm italic">
                                                {{ $booking->status_pembayaran == 'lunas' ? '✅ Selesai' : '❌ Dibatalkan' }}
                                            </span>
                                        @endif
                                    </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-500">Belum ada data pesanan lapangan.</td>
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