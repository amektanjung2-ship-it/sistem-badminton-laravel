<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Booking Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                
                <h3 class="text-2xl font-bold text-blue-700 mb-2">{{ $lapangan->nama_lapangan }}</h3>
                <p class="text-gray-600 mb-6">Harga: Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} / Jam</p>

                <form action="#" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Main</label>
                            <input type="date" name="tanggal_main" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Ingin Sewa Alat Sekalian? (Opsional)</h4>
                    <div class="space-y-3 mb-6">
                        @foreach($alats as $alat)
                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded border">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $alat->nama_alat }}</p>
                                <p class="text-sm text-gray-600">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }} / Sesi</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <label class="text-sm text-gray-600">Jumlah:</label>
                                <input type="number" name="alat[{{ $alat->id }}]" min="0" max="{{ $alat->stok }}" value="0" class="w-20 border-gray-300 rounded-md shadow-sm focus:border-blue-500">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-md">
                            Lanjut ke Pembayaran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>