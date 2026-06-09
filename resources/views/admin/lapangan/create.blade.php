<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Lapangan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- WAJIB: enctype="multipart/form-data" agar file bisa diupload --}}
                <form action="{{ route('admin.lapangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nama Lapangan</label>
                        <input type="text" name="nama_lapangan" placeholder="Contoh: Lapangan VIP C" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Harga Sewa per Jam (Rp)</label>
                        <input type="number" name="harga_per_jam" placeholder="Contoh: 50000" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Status Lapangan</label>
                        <select name="status_aktif" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            <option value="1">Aktif (Bisa Disewa)</option>
                            <option value="0">Nonaktif (Sedang Perbaikan)</option>
                        </select>
                    </div>

                    {{-- FIELD UPLOAD FOTO --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Foto Lapangan <span class="text-gray-400 font-normal text-xs">(Opsional, maks 2MB)</span></label>
                        <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50 transition-all duration-200">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm text-gray-500">Klik untuk pilih gambar atau seret ke sini</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — Maksimal 2MB</p>
                            <input type="file" name="foto" id="fotoInput" accept="image/*" class="hidden">
                        </div>
                        {{-- Preview foto sebelum upload --}}
                        <div id="previewContainer" class="mt-3 hidden">
                            <img id="previewImg" src="" alt="Preview" class="w-full max-h-48 object-cover rounded-xl border border-gray-200">
                            <p id="namaFile" class="text-xs text-gray-500 mt-1 text-center"></p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <a href="{{ route('admin.lapangan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2 transition">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-md transition">
                            Simpan Lapangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fotoInput = document.getElementById('fotoInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImg = document.getElementById('previewImg');
        const namaFile = document.getElementById('namaFile');

        dropZone.addEventListener('click', () => fotoInput.click());

        fotoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();
                reader.onload = e => {
                    previewImg.src = e.target.result;
                    namaFile.textContent = file.name;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>