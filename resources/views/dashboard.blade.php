<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pemesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">🏸 Daftar Lapangan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($lapangans as $lapangan)
                    <div class="border rounded-lg p-5 shadow-sm hover:shadow-md transition bg-gray-50">
                        <h4 class="font-bold text-lg text-blue-700">{{ $lapangan->nama_lapangan }}</h4>
                        <p class="text-gray-600 mt-1">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} / Jam</p>

                        <a href="{{ route('booking.create', $lapangan->id) }}" class="mt-4 inline-block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                            Pilih Jadwal
                        </a>
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

        </div>
    </div>
</x-app-layout>