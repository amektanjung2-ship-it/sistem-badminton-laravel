<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Booking Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                        <p class="font-bold">Gagal Booking</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <h3 class="text-2xl font-bold text-blue-700 mb-2">{{ $lapangan->nama_lapangan }}</h3>
                <p class="text-gray-600 mb-6">Harga: Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} / Jam</p>

                <form action="{{ route('booking.store', $lapangan->id) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 border-b pb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Main</label>
                            <input type="date" name="tanggal_main" min="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jam Mulai</label>
                            <select name="jam_mulai" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                <option value="" disabled selected>-- Pilih Jam --</option>
                                @for($i = 8; $i <= 23; $i++)
                                    <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Durasi Main</label>
                            <select name="durasi" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                <option value="1">1 Jam</option>
                                <option value="2">2 Jam</option>
                                <option value="3">3 Jam</option>
                                <option value="4">4 Jam</option>
                            </select>
                        </div>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 mb-4">Ingin Sewa Alat Sekalian? (Opsional)</h4>
                    <div class="space-y-3 mb-8">
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

                    <div class="flex justify-end pt-4 border-t">
                        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2 transition">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-md transition">
                            Booking Sekarang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>