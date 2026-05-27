<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Inventaris & Perlengkapan
            </h2>
            <a href="{{ route('admin.alat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition shadow-sm">
                + Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Informasi Barang</th>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tarif / Harga</th>
                                <th class="py-3 px-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Ketersediaan Stok</th>
                                <th class="py-3 px-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($alats as $index => $alat)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="py-4 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                
                                <td class="py-4 px-4">
                                    <div class="font-bold text-gray-800 text-base">{{ $alat->nama_alat }}</div>
                                    <span class="inline-block mt-1 bg-gray-200 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                                        {{ $alat->jenis_transaksi }}
                                    </span>
                                </td>
                                
                                <td class="py-4 px-4 text-sm font-medium text-gray-700">
                                    Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}
                                </td>
                                
                                <td class="py-4 px-4">
                                    @if(strtolower($alat->jenis_transaksi) == 'sewa')
                                        <div class="text-sm">
                                            <span class="text-gray-600 block mb-2 font-medium">
                                                Master Aset: <span class="text-gray-900 font-bold">{{ $alat->stok }}</span>
                                            </span>
                                            
                                            @if($alat->sedang_disewa > 0)
                                                <div class="flex flex-col space-y-1">
                                                    <span class="inline-block bg-amber-100 text-amber-800 text-[10px] uppercase font-bold tracking-wide px-2 py-1 rounded border border-amber-200 w-max">
                                                        Sedang Digunakan: {{ $alat->sedang_disewa }}
                                                    </span>
                                                    <span class="inline-block bg-emerald-100 text-emerald-800 text-[10px] uppercase font-bold tracking-wide px-2 py-1 rounded border border-emerald-200 w-max">
                                                        Sisa Tersedia: {{ $alat->stok - $alat->sedang_disewa }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="inline-block bg-emerald-100 text-emerald-800 text-[10px] uppercase font-bold tracking-wide px-2 py-1 rounded border border-emerald-200 w-max">
                                                    Kapasitas Penuh: {{ $alat->stok }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-sm">
                                            <span class="font-bold text-gray-900 text-base">{{ $alat->stok }}</span>
                                            <span class="text-[10px] text-gray-500 block uppercase tracking-wide mt-1">Fisik Gudang</span>
                                        </div>
                                    @endif
                                </td>
                                
                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.alat.edit', $alat->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-200 text-xs font-bold py-1.5 px-3 rounded transition">Edit</a>
                                        <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data inventaris ini secara permanen?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 text-xs font-bold py-1.5 px-3 rounded transition">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-500 font-medium">Data inventaris belum tersedia di dalam sistem.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>