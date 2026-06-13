<x-app-layout>
    {{-- BARU: HERO BANNER GELAP (Persis seperti Screenshot (453).jpg) --}}
    <div class="bg-cover bg-center bg-no-repeat relative pt-12 pb-32" 
         style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.95) 50%, rgba(15, 23, 42, 0.9) 100%), url('https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=1920&auto=format&fit=crop');">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    {{-- Badge Hijau Kecil di Atas Judul --}}
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase tracking-wider mb-3">
                        Panel Kendali Utama
                    </span>
                    {{-- Judul Utama Putih Kontras --}}
                    <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                        {{ __('Manajemen Data Pelanggan') }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-400 max-w-2xl">
                        Pantau statistik pengguna, kelola otorisasi hak akses, validasi identitas, dan verifikasi status keanggotaan VIP secara langsung.
                    </p>
                </div>
                
                {{-- Tombol Aksi Opsional di Sisi Kanan Banner --}}
                <div class="flex-shrink-0">
                    <div class="inline-flex items-center gap-2 bg-emerald-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-900/20 border border-emerald-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Sistem Terverifikasi
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTEN UTAMA: Dibuat bergeser ke atas memotong banner dengan margin-top negatif (-mt-24) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 -mt-24 relative z-20 space-y-8">

        {{-- NOTIFIKASI SISTEM --}}
        @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-2xl shadow-md flex items-start transform transition-all duration-300 animate-fade-in-down backdrop-blur-sm">
            <div class="flex-shrink-0 text-emerald-500 mt-0.5">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-bold text-emerald-900">Berhasil</p>
                <p class="text-sm font-medium text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- KARTU STATISTIK MINI DASHBOARD (Overlapping di atas Hero) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Total Pelanggan --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-lg flex items-center gap-5 transform transition hover:-translate-y-1 duration-200">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100/80 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pelanggan</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-0.5 tracking-tight">{{ $pelanggans->count() }}</h4>
                </div>
            </div>

            {{-- Member VIP --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-lg flex items-center gap-5 transform transition hover:-translate-y-1 duration-200">
                <div class="p-4 bg-amber-50 text-amber-600 rounded-xl border border-amber-100/80 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Member VIP</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-0.5 tracking-tight">{{ $pelanggans->where('is_member', true)->count() }}</h4>
                </div>
            </div>

            {{-- User Reguler --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-lg flex items-center gap-5 transform transition hover:-translate-y-1 duration-200">
                <div class="p-4 bg-blue-50 text-blue-600 rounded-xl border border-blue-100/80 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">User Reguler</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-0.5 tracking-tight">{{ $pelanggans->where('is_member', false)->count() }}</h4>
                </div>
            </div>
        </div>

        {{-- KONTEN UTAMA TABEL --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-slate-200/80">
            <div class="p-6 md:p-8">
                
                {{-- HEADER INTERNAL TABEL --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Pengguna Terdaftar</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola hak otorisasi akun, promosi keanggotaan, serta data kontak aktif.</p>
                    </div>
                </div>

                {{-- TABEL DATA MODERN --}}
                <div class="overflow-x-auto rounded-xl border border-slate-200/60 shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200 text-left text-sm bg-white">
                        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-600 tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-center w-16">No</th>
                                <th class="px-6 py-4">Nama Pelanggan</th>
                                <th class="px-6 py-4">Kontak & Email</th>
                                <th class="px-6 py-4">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-center">Status Akun</th>
                                <th class="px-6 py-4 text-center w-48">Aksi Keanggotaan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($pelanggans as $pelanggan)
                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                {{-- Nomor --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-slate-500 font-medium">{{ $loop->iteration }}</td>
                                
                                {{-- Nama --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-semibold text-slate-900">{{ $pelanggan->name }}</div>
                                </td>
                                
                                {{-- Kontak --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-slate-600 font-medium">{{ $pelanggan->email }}</div>
                                    <div class="mt-0.5 flex items-center gap-1.5">
                                        @if($pelanggan->no_hp)
                                            <span class="text-xs text-slate-500">{{ $pelanggan->no_hp }}</span>
                                        @else
                                            <span class="text-slate-400 italic text-xs">Belum mengisi nomor</span>
                                        @endif
                                    </div>
                                </td>
                                
                                {{-- Tanggal --}}
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                    <span class="font-medium text-slate-700">{{ $pelanggan->created_at->format('d M Y') }}</span>
                                    <span class="text-xs text-slate-400 block mt-0.5">{{ $pelanggan->created_at->format('H:i') }} WIB</span>
                                </td>
                                
                                {{-- Badge Status --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($pelanggan->is_member)
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full border border-amber-200/60 shadow-sm uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Member VIP
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-full border border-slate-200 uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Reguler
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Tombol Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                    <form action="{{ route('admin.pelanggan.member', $pelanggan->id) }}" method="POST" class="inline-block w-full">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @if($pelanggan->is_member)
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mencabut status Member VIP dari pengguna ini?')" class="group inline-flex items-center justify-center bg-white border border-slate-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200 text-slate-700 text-xs font-bold py-2 px-4 rounded-xl shadow-sm transition-all duration-200 w-full">
                                                <svg class="w-4 h-4 mr-1.5 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Cabut Akses VIP
                                            </button>
                                        @else
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin memberikan akses Member VIP kepada pengguna ini?')" class="inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2 px-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 w-full gap-1.5">
                                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                Jadikan VIP Member
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-slate-400 font-medium bg-slate-50/30">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-2.533-3.076l-1.408-.47A15.614 15.614 0 0014 13.013m-3.493 5.503a3 3 0 001.918-.21l2.251-1.124a3 3 0 001.614-2.682V10.5m-6-2.25h.008v.008H6V8.25z" />
                                        </svg>
                                        <span class="text-sm">Belum ada data pengguna yang terdaftar di dalam sistem.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>