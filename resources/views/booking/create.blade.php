<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            {{-- Mengembalikan judul ke warna hijau gelap/emerald agar kontras dengan header putih --}}
            <h2 class="font-bold text-2xl text-emerald-600 leading-tight">
                Formulir Pemesanan {{ $lapangan->nama_lapangan }}
            </h2>

            @if(auth()->user()->is_member)
            <span class="bg-gradient-to-r from-amber-400 to-yellow-500 text-white text-xs font-extrabold px-4 py-1.5 rounded-full shadow-sm border border-yellow-300 uppercase tracking-widest">
                Member VIP (Diskon 10%)
            </span>
            @endif
        </div>
    </x-slot>

    {{-- LAYER BACKGROUND PEMAIN BADMINTON (Tetap dipertahankan gelap estetis) --}}
    <div class="py-12 relative min-h-screen bg-slate-950 overflow-x-hidden">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/90 to-slate-950 z-10"></div>
            <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=2070&auto=format&fit=crop" 
                 alt="Badminton Background" 
                 class="w-full h-full object-cover object-center fixed top-0 left-0 transform scale-105 filter blur-[2px]">
        </div>

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 relative z-10">

            @if (session('error'))
            <div class="p-4 mb-6 text-sm text-red-200 rounded-xl bg-red-950/50 backdrop-blur-md border-l-4 border-red-500 shadow-md flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <span class="font-bold block mb-0.5 text-red-400">Peringatan Sistem</span>
                    {{ session('error') }}
                </div>
            </div>
            @endif

            {{-- KOTAK TABEL UTAMA: Dikembalikan ke bg-white (Putih bersih bawaan web) --}}
            <div class="bg-white p-6 md:p-8 shadow-xl sm:rounded-2xl border border-gray-200 text-gray-900">
                
                <form action="{{ route('booking.store', $lapangan->id) }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                        {{-- BAGIAN KIRI: WAKTU SEWA --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-5 border-b border-gray-200 pb-3 flex items-center gap-2">
                                <span class="bg-emerald-500 text-white w-6 h-6 rounded flex items-center justify-center text-sm font-extrabold">1</span>
                                Rincian Waktu Sewa
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-gray-700 font-bold text-sm mb-2" for="inputTanggal">Tanggal Pemakaian</label>
                                    {{-- Input tanggal putih bawaan web --}}
                                    <input type="date" id="inputTanggal" name="tanggal_main" class="w-full bg-white border-gray-300 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors focus:outline-none" required value="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-bold text-sm mb-3">Jam Mulai</label>

                                    {{-- Input tersembunyi untuk menampung data yang akan dikirim ke backend --}}
                                    <input type="hidden" name="jam_mulai" id="jamMulaiFinal" required>

                                    {{-- Grid Tombol Slot Waktu --}}
                                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-2" id="wadahSlotWaktu">
                                        @for ($i = 8; $i <= 22; $i++)
                                            @php $jam=sprintf('%02d:00', $i); @endphp
                                            <button type="button"
                                            class="tombol-waktu py-2 px-1 border border-gray-300 rounded-lg text-sm font-bold text-gray-600 hover:border-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all focus:outline-none bg-white"
                                            data-waktu="{{ $jam }}">
                                            {{ $jam }}
                                            </button>
                                        @endfor
                                    </div>
                                    <p class="text-[11px] text-gray-400 mt-2.5">*Silakan klik salah satu blok jam di atas.</p>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-bold text-sm mb-2" for="durasi">Durasi Pemakaian (Jam)</label>
                                    <input type="number" id="durasi" name="durasi" min="1" max="10" step="1" value="1" class="w-full bg-white border-gray-300 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors focus:outline-none" required>
                                    <p class="text-[11px] text-gray-400 mt-1.5">*Penjadwalan dikelola dalam blok 1 jam. Masukkan angka bulat (Contoh: 1, 2, atau 3).</p>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN KANAN: KETERSEDIAAN JADWAL --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-5 border-b border-gray-200 pb-3 flex items-center gap-2">
                                <span class="bg-blue-500 text-white w-6 h-6 rounded flex items-center justify-center text-sm font-extrabold">2</span>
                                Status Ketersediaan
                            </h3>
                            <p class="text-xs text-gray-500 mb-4">Waktu yang tertera di bawah ini menandakan slot yang <span class="font-bold text-red-500 uppercase">telah dipesan</span>.</p>

                            {{-- Wadah Kalender Abu-abu Terang Bawaan Web --}}
                            <div id="gridKalender" class="grid grid-cols-4 gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100 min-h-[200px] content-start">
                                <div class="col-span-4 flex justify-center py-8">
                                    <p class="text-sm font-bold text-emerald-600 animate-pulse">Menyinkronkan data jadwal...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN BAWAH: INVENTARIS --}}
                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <span class="bg-teal-500 text-white w-6 h-6 rounded flex items-center justify-center text-sm font-extrabold">3</span>
                            Inventaris Tambahan (Opsional)
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($alats as $alat)
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-emerald-500/50 hover:shadow-lg transition-all duration-200 bg-white flex flex-col justify-between group relative overflow-hidden">
                                <div>
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="font-bold text-gray-700 text-sm">{{ $alat->nama_alat }}</h4>
                                        <span class="text-[9px] bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded font-bold uppercase">{{ $alat->jenis_transaksi }}</span>
                                    </div>
                                    <p class="text-emerald-600 font-bold text-sm mt-1">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</p>
                                    <p class="text-[10px] font-bold mt-1 {{ $alat->stok > 0 ? 'text-teal-600' : 'text-red-500' }}">Sisa Stok: {{ $alat->stok }}</p>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <input type="number" name="alat[{{ $alat->id }}]" min="0" max="{{ $alat->stok }}" value="0" class="w-full text-sm font-bold text-center bg-white border-gray-300 text-gray-900 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- JIKA ADMIN: ISI NAMA PEMESAN --}}
                    @if(auth()->user() && auth()->user()->role === 'admin')
                    <div class="mt-6">
                        <label class="block text-gray-700 font-bold text-sm mb-2" for="nama_pemesan">Nama Pemesan (bila memesan untuk pelanggan lain)</label>
                        <input type="text" id="nama_pemesan" name="nama_pemesan" maxlength="255" class="w-full bg-white border-gray-300 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors focus:outline-none" placeholder="Contoh: Tarakhan">
                        <p class="text-[11px] text-gray-400 mt-1.5">Opsional: isi nama pelanggan jika Anda memesan atas nama orang lain.</p>
                    </div>
                    @endif

                    {{-- TOMBOL SUBMIT --}}
                    <div class="flex justify-end gap-3 mt-10 bg-gray-50 -mx-6 -mb-6 md:-mx-8 md:-mb-8 p-6 md:p-8 rounded-b-2xl border-t border-gray-200">
                        <a href="{{ route('dashboard') }}" class="bg-white border border-gray-300 text-gray-700 font-bold py-2.5 px-6 rounded-xl hover:bg-gray-50 transition shadow-sm flex items-center">
                            Batal
                        </a>
                        <button type="submit" class="bg-emerald-600 text-white font-bold py-2.5 px-8 rounded-xl shadow-md hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 transition flex items-center gap-2">
                            Proses Pemesanan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT INTERAKTIF (KALENDER & TOMBOL WAKTU) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputTanggal = document.getElementById('inputTanggal');
            const gridKalender = document.getElementById('gridKalender');
            const lapanganId = "{{ $lapangan->id }}";

            // --- 1. LOGIKA TOMBOL SLOT WAKTU ---
            const tombolWaktu = document.querySelectorAll('.tombol-waktu');
            const inputJamTersembunyi = document.getElementById('jamMulaiFinal');

            function updateTombolJam() {
                const tanggalPilihan = inputTanggal.value;
                const hariIni = new Date().toISOString().split('T')[0];
                const jamSekarang = new Date().getHours() * 60 + new Date().getMinutes();

                tombolWaktu.forEach(tombol => {
                    const waktu = tombol.getAttribute('data-waktu');
                    const jamTombol = parseInt(waktu.split(':')[0]) * 60;

                    const sudahLewat = (tanggalPilihan === hariIni) && (jamTombol <= jamSekarang);

                    if (sudahLewat) {
                        // Jika sudah lewat: tombol jadi abu-abu mati/disabled ringan bawaan web terang
                        tombol.disabled = true;
                        tombol.classList.remove('border-gray-300', 'text-gray-600', 'hover:border-emerald-500', 'hover:text-emerald-600', 'hover:bg-emerald-50', 'bg-emerald-600', 'text-white', 'border-emerald-600', 'shadow-md');
                        tombol.classList.add('bg-gray-100', 'border-gray-200', 'text-gray-400', 'cursor-not-allowed');
                        if (inputJamTersembunyi.value === waktu) {
                            inputJamTersembunyi.value = '';
                        }
                    } else {
                        // Reset ke normal putih terang
                        tombol.disabled = false;
                        tombol.classList.remove('bg-gray-100', 'border-gray-200', 'text-gray-400', 'cursor-not-allowed');
                        tombol.classList.add('border-gray-300', 'text-gray-600', 'hover:border-emerald-500', 'hover:text-emerald-600', 'hover:bg-emerald-50', 'bg-white');
                    }
                });
            }

            updateTombolJam();
            inputTanggal.addEventListener('change', updateTombolJam);

            tombolWaktu.forEach(tombol => {
                tombol.addEventListener('click', function() {
                    if (this.disabled) return;

                    // Hapus status aktif (hijau) dari semua tombol
                    tombolWaktu.forEach(btn => {
                        if (!btn.disabled) {
                            btn.classList.remove('bg-emerald-600', 'text-white', 'border-emerald-600', 'shadow-md');
                            btn.classList.add('text-gray-600', 'border-gray-300', 'bg-white');
                        }
                    });

                    // Aktifkan tombol pilihan (Emerald Hijau)
                    this.classList.remove('text-gray-600', 'border-gray-300', 'bg-white');
                    this.classList.add('bg-emerald-600', 'text-white', 'border-emerald-600', 'shadow-md');

                    inputJamTersembunyi.value = this.getAttribute('data-waktu');
                });
            });

            // --- 2. LOGIKA SINKRONISASI JADWAL TERISI ---
            function muatJadwal() {
                const tanggalPilihan = inputTanggal.value;
                gridKalender.innerHTML = '<div class="col-span-4 flex justify-center py-8"><p class="text-sm font-bold text-emerald-600 animate-pulse">Menyinkronkan...</p></div>';

                fetch(`/api/jadwal/${lapanganId}?tanggal=${tanggalPilihan}`)
                    .then(response => response.json())
                    .then(data => {
                        const jamTerpakai = data.terpakai;
                        gridKalender.innerHTML = '';

                        if (jamTerpakai.length === 0) {
                            gridKalender.innerHTML = `
                                <div class="col-span-4 flex flex-col items-center justify-center py-6 text-emerald-600">
                                    <svg class="w-8 h-8 mb-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="font-bold text-sm block">Seluruh Slot Tersedia</span>
                                </div>
                            `;
                            return;
                        }

                        jamTerpakai.forEach(jadwal => {
                            const startTime = jadwal.start.substring(0, 5);
                            const endTime = jadwal.end.substring(0, 5);

                            // Kotak penanda jadwal terisi diubah ke gaya putih dengan border merah halus (bawaan web)
                            const kotakHTML = `
                                <div class="col-span-4 sm:col-span-2 bg-white border border-red-200 rounded-lg p-2.5 text-center shadow-sm">
                                    <span class="text-[9px] uppercase font-bold text-red-500 tracking-widest block">Telah Dipesan</span>
                                    <span class="text-sm font-extrabold text-gray-800">${startTime} - ${endTime}</span>
                                </div>
                            `;
                            gridKalender.insertAdjacentHTML('beforeend', kotakHTML);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        gridKalender.innerHTML = '<div class="col-span-4 text-center text-red-500 text-xs font-bold py-4">Koneksi server terputus.</div>';
                    });
            }

            inputTanggal.addEventListener('change', muatJadwal);
            muatJadwal();
        });
    </script>
</x-app-layout>