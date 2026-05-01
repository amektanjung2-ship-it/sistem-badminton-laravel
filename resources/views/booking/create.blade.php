<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-2xl text-emerald-800 leading-tight">
                🏸 Pesan {{ $lapangan->nama_lapangan }}
            </h2>

            {{-- MUNCULKAN LABEL INI KHUSUS UNTUK MEMBER --}}
            @if(auth()->user()->is_member)
            <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white text-xs font-extrabold px-3 py-1 rounded-full shadow-sm border border-yellow-300">
                👑 MEMBER (DISKON 10%)
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
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">1. Pilih Waktu Bermain</h3>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Tanggal Main</label>
                                <input type="date" id="inputTanggal" name="tanggal_main" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" required value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Jam Mulai (Bebas Pilih Menit)</label>
                                {{-- PERUBAHAN: Sekarang pakai input type="time" biar bisa input 08:15, 09:30, dll --}}
                                <input type="time" name="jam_mulai" min="08:00" max="23:00" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" required>
                                <p class="text-xs text-gray-500 mt-1">*Jam operasional: 08:00 - 23:00</p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-bold mb-2">Durasi (Jam)</label>
                                {{-- PERUBAHAN: Tambah step="0.5" biar pelanggan bisa sewa 1.5 jam (1 jam setengah) --}}
                                <input type="number" name="durasi" min="0.5" max="10" step="0.5" value="1" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" required>
                                <p class="text-xs text-gray-500 mt-1">*Bisa sewa setengah jam (misal ketik: 1.5 untuk 1,5 jam)</p>
                            </div>
                        </div>

                        {{-- KANAN: KALENDER INTERAKTIF --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">2. Cek Ketersediaan Lapangan</h3>
                            <p class="text-xs text-gray-500 mb-3">*Berikut adalah daftar jam yang <span class="text-red-500 font-bold">SUDAH DIPESAN</span> orang lain.</p>

                            <div id="gridKalender" class="grid grid-cols-4 gap-3">
                                <p class="col-span-4 text-center text-sm text-emerald-600 animate-pulse">Memuat jadwal akurat...</p>
                            </div>
                        </div>
                    </div>

                    {{-- BAWAH: SEWA ALAT (Opsional) --}}
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">3. Sewa/Beli Perlengkapan (Opsional)</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($alats as $alat)
                            <div class="border rounded-xl p-4 bg-slate-50 flex flex-col justify-between hover:shadow-md transition border-gray-200">
                                <div>
                                    <h4 class="font-bold text-teal-800">{{ $alat->nama_alat }} <span class="text-[10px] bg-slate-200 px-2 py-0.5 rounded text-gray-600">{{ $alat->jenis_transaksi }}</span></h4>
                                    <p class="text-sm text-gray-600 mt-1">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</p>
                                    <p class="text-xs font-bold text-emerald-600 mt-1">Sisa Stok: {{ $alat->stok }}</p>
                                </div>
                                <div class="mt-3">
                                    <input type="number" name="alat[{{ $alat->id }}]" min="0" max="{{ $alat->stok }}" value="0" class="w-full text-sm border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="mt-8 text-right bg-gray-50 -mx-6 -mb-6 md:-mx-8 md:-mb-8 p-6 md:p-8 rounded-b-2xl border-t border-gray-200 flex justify-end gap-3">
                        <a href="{{ route('dashboard') }}" class="bg-white border border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl hover:bg-gray-50 transition shadow-sm">Kembali</a>
                        <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 transition">Selesaikan Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 🪄 JAVASCRIPT UNTUK KALENDER INTERAKTIF VERSI BARU --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputTanggal = document.getElementById('inputTanggal');
            const gridKalender = document.getElementById('gridKalender');
            const lapanganId = "{{ $lapangan->id }}"; 

            // Fungsi untuk meminta data jadwal ke server
            function muatJadwal() {
                const tanggalPilihan = inputTanggal.value;
                gridKalender.innerHTML = '<p class="col-span-4 text-center text-sm text-emerald-600 animate-pulse py-4">Memuat jadwal...</p>';

                // Fetch ke API
                fetch(`/api/jadwal/${lapanganId}?tanggal=${tanggalPilihan}`)
                    .then(response => response.json())
                    .then(data => {
                        const jamTerpakai = data.terpakai;
                        gridKalender.innerHTML = ''; // Bersihkan isi wadah

                        // Jika jadwal kosong seharian
                        if (jamTerpakai.length === 0) {
                            gridKalender.innerHTML = `
                                <div class="col-span-4 bg-emerald-50 border border-emerald-200 text-emerald-700 p-6 rounded-xl text-center shadow-sm">
                                    <span class="text-3xl block mb-2">🎉</span>
                                    <span class="font-bold text-lg block">Lapangan Kosong!</span>
                                    <span class="text-sm">Silakan bebas memilih jam bermain di tanggal ini.</span>
                                </div>
                            `;
                            return; // Stop di sini
                        }

                        // Jika ada jadwal, tampilkan daftar waktu spesifik yang terpakai
                        jamTerpakai.forEach(jadwal => {
                            // Potong tulisan detiknya (08:15:00 jadi 08:15)
                            const startTime = jadwal.start.substring(0, 5);
                            const endTime = jadwal.end.substring(0, 5);

                            const kotakHTML = `
                                <div class="col-span-4 sm:col-span-2 bg-red-50 border border-red-200 rounded-xl p-3 text-center shadow-sm">
                                    <span class="text-[10px] uppercase font-bold text-red-500 tracking-wider block mb-1">Sudah Dipesan</span>
                                    <span class="text-base font-extrabold text-red-700">🔴 ${startTime} - ${endTime}</span>
                                </div>
                            `;
                            gridKalender.insertAdjacentHTML('beforeend', kotakHTML);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        gridKalender.innerHTML = '<p class="col-span-4 text-center text-red-500 text-sm py-4">Gagal terhubung ke server. Muat ulang halaman.</p>';
                    });
            }

            // Panggil fungsi saat halaman pertama kali dibuka
            muatJadwal();

            // Panggil ulang fungsi SETIAP KALI pelanggan mengganti tanggal di kalender
            inputTanggal.addEventListener('change', muatJadwal);
        });
    </script>
</x-app-layout>