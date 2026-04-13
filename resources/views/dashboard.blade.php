<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">🏸 Daftar Lapangan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($lapangans as $lapangan)
                    <div class="border rounded-lg p-5 shadow-sm hover:shadow-md transition bg-gray-50 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-lg text-blue-700">{{ $lapangan->nama_lapangan }}</h4>
                            <p class="text-gray-600 mt-1">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} / Jam</p>
                        </div>
                        <a href="{{ route('booking.create', $lapangan->id) }}" class="mt-4 inline-block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                            Pilih Jadwal
                        </a>
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">👟 Sewa Perlengkapan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($alats as $alat)
                    <div class="border rounded-lg p-5 shadow-sm hover:shadow-md transition bg-gray-50">
                        <h4 class="font-bold text-lg text-green-700">{{ $alat->nama_alat }}</h4>
                        <p class="text-gray-600 mt-1">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }} / Sesi</p>
                        <p class="text-sm font-medium mt-2 {{ $alat->stok > 2 ? 'text-green-600' : 'text-red-500' }}">
                            Stok Tersedia: {{ $alat->stok }}
                        </p>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">🕰️ Riwayat Pesanan Saya</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Tanggal Transaksi</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Lapangan</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Jadwal Main</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Total Tagihan</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat_bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-4 border-b text-sm text-gray-700">
                                    {{ $booking->created_at->format('d M Y') }}
                                </td>
                                <td class="py-3 px-4 border-b font-medium text-gray-800">
                                    {{ $booking->lapangan->nama_lapangan }}
                                </td>
                                <td class="py-3 px-4 border-b">
                                    <div class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</div>
                                </td>
                                <td class="py-3 px-4 border-b font-semibold text-gray-800">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 border-b text-center">
                                    @if($booking->status_pembayaran == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-300">Menunggu ACC</span>
                                    @elseif($booking->status_pembayaran == 'lunas')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-300 block mb-3 text-center">Lunas</span>

                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('cetak.tiket', $booking->id) }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow transition text-center">
                                            🖨️ Cetak Tiket
                                        </a>

                                        <a href="{{ route('tiket.pdf', $booking->id) }}" class="inline-block bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow transition text-center">
                                            📥 Download PDF
                                        </a>
                                    </div>
                                    @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-300">Batal</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500 italic">Belum ada riwayat pesanan. Yuk, booking lapangan sekarang!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>