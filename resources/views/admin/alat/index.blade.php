<x-app-layout>
    {{-- HERO BANNER GELAP: Tema Premium Badminton Court --}}
    <div class="bg-cover bg-center bg-no-repeat relative pt-12 pb-32" 
         style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.95) 50%, rgba(15, 23, 42, 0.9) 100%), url('https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=1920&auto=format&fit=crop');">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    {{-- Badge Panel --}}
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase tracking-wider mb-3">
                        Panel Admin
                    </span>
                    {{-- Judul Utama --}}
                    <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                        {{ __('Manajemen Inventaris & Perlengkapan') }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-400 max-w-2xl">
                        Kelola ketersediaan raket, kok, net, senar, serta fasilitas pendukung operasional lapangan badminton secara terpusat.
                    </p>
                </div>
                
                {{-- Tombol Tambah Data --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.alat.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-900/20 border border-emerald-500 transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTEN UTAMA: Menjorok ke atas memotong banner (-mt-24) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 -mt-24 relative z-20 space-y-8">

        {{-- NOTIFIKASI SISTEM --}}
        @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-2xl shadow-md flex items-start transform transition-all duration-300 animate-fade-in-down">
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

        {{-- KARTU STATISTIK INVENTARIS (Overlapping Cards) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Total Unit Alat --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-lg flex items-center gap-5 transform transition hover:-translate-y-1 duration-200">
                <div class="p-4 bg-blue-50 text-blue-600 rounded-xl border border-blue-100/80 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V3m0 18v-6M4 11v10l8 4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kapasitas Alat (Stok)</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-0.5 tracking-tight">
                        {{ $alats->sum('stok') }}
                    </h4>
                </div>
            </div>

            {{-- Total Jenis Item --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-lg flex items-center gap-5 transform transition hover:-translate-y-1 duration-200">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100/80 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Jenis Alat</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-0.5 tracking-tight">
                        {{ $alats->count() }} <span class="text-xs font-medium text-slate-400">Item</span>
                    </h4>
                </div>
            </div>

            {{-- Stok Menipis/Habis --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-lg flex items-center gap-5 transform transition hover:-translate-y-1 duration-200">
                <div class="p-4 bg-amber-50 text-amber-600 rounded-xl border border-amber-100/80 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Menipis</p>
                    <h4 class="text-3xl font-extrabold text-slate-800 mt-0.5 tracking-tight">
                        {{ $alats->where('stok', '<', 5)->count() }} <span class="text-xs font-medium text-slate-400">Item</span>
                    </h4>
                </div>
            </div>
        </div>

        {{-- KONTEN UTAMA TABEL INVENTARIS --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-slate-200/80">
            <div class="p-6 md:p-8">
                
                {{-- HEADER INTERNAL TABEL --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Data Logistik Inventaris</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar item penyewaan dan penjualan perlengkapan olahraga.</p>
                    </div>
                </div>

                {{-- TABEL DATA MODERN --}}
                <div class="overflow-x-auto rounded-xl border border-slate-200/60 shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200 text-left text-sm bg-white">
                        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-600 tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-center w-16">No</th>
                                <th class="px-6 py-4">Informasi Barang</th>
                                <th class="px-6 py-4">Tarif / Harga</th>
                                <th class="px-6 py-4">Ketersediaan Stok</th>
                                <th class="px-6 py-4 text-center w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($alats as $index => $alat)
                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-slate-500 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-900 text-base">{{ $alat->nama_alat }}</div>
                                    <span class="inline-block mt-1 bg-slate-100 text-slate-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide border border-slate-200">
                                        {{ $alat->jenis_transaksi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-slate-600">
                                    Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(strtolower($alat->jenis_transaksi) == 'sewa')
                                        <div class="text-sm">
                                            <span class="text-slate-600 block mb-2 font-medium">
                                                Master Aset: <span class="text-slate-900 font-bold">{{ $alat->stok }}</span>
                                            </span>
                                            
                                            @if($alat->sedang_disewa > 0)
                                                <div class="flex flex-col space-y-1">
                                                    <span class="inline-block bg-amber-50 text-amber-800 text-[10px] uppercase font-bold tracking-wide px-2 py-1 rounded-md border border-amber-200 w-max">
                                                        Sedang Digunakan: {{ $alat->sedang_disewa }}
                                                    </span>
                                                    <span class="inline-block bg-emerald-50 text-emerald-800 text-[10px] uppercase font-bold tracking-wide px-2 py-1 rounded-md border border-emerald-200 w-max">
                                                        Sisa Tersedia: {{ $alat->stok - $alat->sedang_disewa }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="inline-block bg-emerald-50 text-emerald-800 text-[10px] uppercase font-bold tracking-wide px-2 py-1 rounded-md border border-emerald-200 w-max">
                                                    Kapasitas Penuh: {{ $alat->stok }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-sm">
                                            <span class="font-bold text-slate-900 text-base">{{ $alat->stok }}</span>
                                            <span class="text-[10px] text-slate-500 block uppercase tracking-wide mt-0.5">Fisik Gudang</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center align-middle">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.alat.edit', $alat->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-200 text-xs font-bold py-1.5 px-3 rounded-lg transition shadow-sm">Edit</a>
                                        
                                        <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data inventaris ini secara permanen?');">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 text-xs font-bold py-1.5 px-3 rounded-lg transition shadow-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center text-slate-400 font-medium bg-slate-50/30">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg>
                                        <span class="text-sm">Data inventaris belum tersedia di dalam sistem.</span>
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