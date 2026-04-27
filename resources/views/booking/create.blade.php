<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-2xl text-emerald-800 leading-tight">
                🏸 Pesan {{ $lapangan->nama_lapangan }}
            </h2>

            {{-- MUNCULKAN LABEL INI KHUSUS UNTUK MEMBER --}}
            @if(auth()->user()->is_member)
            <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white text-xs font-extrabold px-3 py-1 rounded-full shadow-sm border border-yellow-300">
                MEMBER (DISKON 10%)
            </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Error (Dari Controller) --}}
            @if (session('error'))
            <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50 border-l-4 border-red-500 shadow-sm">
                <span class="font-bold">Gagal!</span> {{ session('error') }}
            </div>
            @endif

            <div class="bg-white p-6 md:p-8 shadow-sm sm:rounded-2xl border border-emerald-100">
                <form action="{{ route('booking.store', $lapangan->id) }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- KIRI: TANGGAL & JAM --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">. Pilih Waktu Bermain</h3>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Tanggal Main</label>
                                <input type="date" id="inputTanggal" name="tanggal_main" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" required value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Jam Mulai</label>
                                <select name="jam_mulai" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" required>
                                    @for ($i = 8; $i <= 22; $i++)
                                        <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }}</option>
                                        @endfor
                                </select>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-bold mb-2">Durasi (Jam)</label>
                                <input type="number" name="durasi" min="1" max="5" value="1" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" required>
                            </div>
                        </div>

                        {{-- KANAN: KALENDER INTERAKTIF --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">. Cek Ketersediaan</h3>
                            <p class="text-xs text-gray-500 mb-3">*Kotak <span class="text-red-500 font-bold">merah</span> berarti sudah dipesan orang lain.</p>

                            <div id="gridKalender" class="grid grid-cols-4 gap-2">
                                <p class="col-span-4 text-center text-sm text-emerald-600 animate-pulse">Memuat jadwal...</p>
                            </div>
                        </div>
                    </div>

                    {{-- BAWAH: SEWA ALAT (Opsional) --}}
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">3. Sewa/Beli Perlengkapan (Opsional)</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($alats as $alat)
                            <div class="border rounded-xl p-4 bg-slate-50 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-teal-800">{{ $alat->nama_alat }}</h4>
                                    <p class="text-sm text-gray-600">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }} / Sesi</p>
                                    <p class="text-xs font-bold text-emerald-600 mt-1">Sisa: {{ $alat->stok }}</p>
                                </div>
                                <div class="mt-3">
                                    <input type="number" name="alat[{{ $alat->id }}]" min="0" max="{{ $alat->stok }}" value="0" class="w-full text-sm border-gray-300 rounded-lg">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="mt-8 text-right">
                        <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white font-bold py-3 px-6 rounded-xl mr-2 hover:bg-gray-600 transition">Batal</a>
                        <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:bg-emerald-700 transition">Konfirmasi Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 🪄 JAVASCRIPT UNTUK KALENDER INTERAKTIF --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputTanggal = document.getElementById('inputTanggal');
            const gridKalender = document.getElementById('gridKalender');
            const lapanganId = "{{ $lapangan->id }}"; // Ambil ID lapangan dari Laravel

            // Fungsi untuk meminta data jadwal ke server
            function muatJadwal() {
                const tanggalPilihan = inputTanggal.value;
                gridKalender.innerHTML = '<p class="col-span-4 text-center text-sm text-emerald-600 animate-pulse">Memuat jadwal...</p>';

                // Lakukan fetch ke rute API yang tadi kita buat
                fetch(`/api/jadwal/${lapanganId}?tanggal=${tanggalPilihan}`)
                    .then(response => response.json())
                    .then(data => {
                        const jamTerpakai = data.terpakai;
                        gridKalender.innerHTML = ''; // Bersihkan isi grid

                        // Gambar ulang kotak jam dari jam 08:00 sampai 22:00
                        for (let i = 8; i <= 22; i++) {
                            const isBooked = jamTerpakai.includes(i);

                            // Logika Warna: Merah kalau terpakai, Hijau kalau kosong
                            const warnaBg = isBooked ? 'bg-red-100 border-red-300 text-red-700 opacity-50 cursor-not-allowed' : 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold hover:bg-emerald-200';
                            const statusText = isBooked ? 'Full' : 'Kosong';

                            // Bentuk HTML kotaknya
                            const kotakHTML = `
                                <div class="border rounded-lg p-2 text-center flex flex-col justify-center items-center h-16 ${warnaBg}">
                                    <span class="text-sm">${i.toString().padStart(2, '0')}:00</span>
                                    <span class="text-[10px] uppercase mt-1">${statusText}</span>
                                </div>
                            `;
                            gridKalender.insertAdjacentHTML('beforeend', kotakHTML);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        gridKalender.innerHTML = '<p class="col-span-4 text-center text-red-500 text-sm">Gagal memuat jadwal.</p>';
                    });
            }

            // 1. Panggil fungsi saat halaman pertama kali dibuka
            muatJadwal();

            // 2. Panggil ulang fungsi SETIAP KALI pelanggan mengganti tanggal
            inputTanggal.addEventListener('change', muatJadwal);
        });
    </script>
</x-app-layout>