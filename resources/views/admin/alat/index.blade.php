<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Perlengkapan/jual beli </h2>
            <a href="{{ route('admin.alat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">+ Tambah Alat</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">No</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Nama Alat</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Harga Sewa</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Stok</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alats as $index => $alat)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 border-b font-bold">{{ $alat->nama_alat }}</td>
                                <td class="py-3 px-4 border-b">Rp {{ number_format($alat->harga_sewa, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 border-b text-center font-bold {{ $alat->stok == 0 ? 'text-red-500' : 'text-green-600' }}">{{ $alat->stok }}</td>
                                <td class="py-3 px-4 border-b text-center flex justify-center space-x-2">
                                    <a href="{{ route('admin.alat.edit', $alat->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold py-1 px-3 rounded">Edit</a>
                                    <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Yakin hapus alat ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-2 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada data perlengkapan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>