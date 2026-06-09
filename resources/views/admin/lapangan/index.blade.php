<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-emerald-800 leading-tight">
            {{ __('Manajemen Fasilitas Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- NOTIFIKASI SISTEM --}}
            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-6 flex items-start">
                <div class="flex-shrink-0 text-emerald-500 mt-0.5">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-800">Pemberitahuan</p>
                    <p class="text-sm font-medium text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <div class="p-6 md:p-8">

                    {{-- HEADER TABEL & KONTROL --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-emerald-50 rounded-lg text-emerald-600 border border-emerald-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Daftar Lapangan</h3>
                                <p class="text-sm text-gray-500 mt-1">Kelola data dan tarif fasilitas lapangan yang tersedia.</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.lapangan.create') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2.5 px-5 rounded-xl shadow-sm transition-colors w-full sm:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Lapangan
                            </a>
                        </div>
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full bg-white text-left">
                            <thead class="bg-slate-50 border-b border-gray-200">
                                <tr>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider w-16">No</th>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider w-20">Foto</th>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider">Detail Lapangan</th>
                                    <th class="py-4 px-5 text-xs font-bold text-gray-600 uppercase tracking-wider">Tarif / Jam</th>
                                    <th class="py-4 px-5 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                {{-- Ganti $lapangans jika nama variabel di controller Anda berbeda --}}
                                @forelse($lapangans as $index => $lapangan)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="py-4 px-5 text-sm text-gray-500 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-4 px-5">
                                        @if($lapangan->foto)
                                            <img src="{{ Storage::url($lapangan->foto) }}" alt="Foto {{ $lapangan->nama_lapangan }}" class="w-14 h-14 object-cover rounded-lg border border-gray-200 shadow-sm">
                                        @else
                                            <div class="w-14 h-14 bg-slate-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="font-bold text-gray-900 text-sm">{{ $lapangan->nama_lapangan }}</div>
                                        <span class="inline-block mt-1 bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">Tersedia</span>
                                    </td>
                                    <td class="py-4 px-5 text-sm font-bold text-gray-800">
                                        Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-5 align-middle">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.lapangan.edit', $lapangan->id) }}" class="inline-flex items-center justify-center bg-white border border-gray-300 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-300 text-gray-600 p-2 rounded-lg shadow-sm transition-colors" title="Edit Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.lapangan.destroy', $lapangan->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus data lapangan ini?')" class="inline-flex items-center justify-center bg-white border border-gray-300 hover:bg-red-50 hover:text-red-600 hover:border-red-300 text-gray-600 p-2 rounded-lg shadow-sm transition-colors" title="Hapus Data">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-gray-500 font-medium">Data lapangan belum tersedia. Silakan daftarkan fasilitas baru.</td>
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