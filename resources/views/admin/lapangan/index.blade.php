<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Data Lapangan') }}
            </h2>
            <a href="{{ route('admin.lapangan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                + Tambah Lapangan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">No</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Nama Lapangan</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Harga / Jam</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Status</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lapangans as $index => $lapangan)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 border-b text-gray-700">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 border-b font-bold text-gray-800">{{ $lapangan->nama_lapangan }}</td>
                                    <td class="py-3 px-4 border-b text-gray-700">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 border-b text-center">
                                        @if($lapangan->status_aktif)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-300">Aktif</span>
                                        @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-300">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border-b text-center flex justify-center space-x-2">
                                        <a href="{{ route('admin.lapangan.edit', $lapangan->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold py-1 px-3 rounded transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.lapangan.destroy', $lapangan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lapangan ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-2 rounded transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500">Belum ada data lapangan.</td>
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