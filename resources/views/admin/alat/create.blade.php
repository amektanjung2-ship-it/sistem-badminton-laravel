<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Alat Baru</h2></x-slot>
    <div class="py-12"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8"><div class="bg-white p-6 shadow-sm sm:rounded-lg">
        @if ($errors->any()) <div class="bg-red-100 text-red-700 p-4 mb-6 rounded"><ul class="list-disc ml-5">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div> @endif

        <form action="{{ route('admin.alat.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Perlengkapan</label>
                <input type="text" name="nama_alat" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Harga Sewa (Rp)</label>
                <input type="number" name="harga_sewa" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Jumlah Stok</label>
                <input type="number" name="stok" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div class="flex justify-end pt-4 border-t">
                <a href="{{ route('admin.alat.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded">Simpan Data</button>
            </div>
        </form>
    </div></div></div>
</x-app-layout>