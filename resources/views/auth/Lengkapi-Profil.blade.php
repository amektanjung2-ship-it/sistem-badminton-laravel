<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Lengkapi Nomor WhatsApp</h2>
        <p class="text-sm text-gray-500 mt-2">Untuk melanjutkan penggunaan layanan e-badminton, Anda wajib memperbarui nomor WhatsApp aktif terlebih dahulu.</p>
    </div>

    @if (session('error'))
        <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('profil.update-nomor') }}">
        @csrf
        <div>
            <label for="no_hp" class="block font-medium text-sm text-gray-700">Nomor WhatsApp (Aktif)</label>
            <input id="no_hp" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm" 
                   type="text" name="nomor_hp" required placeholder="Contoh: 62895xxxxx" autofocus />
            <span class="text-xs text-gray-400 mt-1 block">*Pastikan nomor berformat 628xxx untuk menerima notifikasi booking.</span>
            <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition">
                Simpan & Lanjutkan
            </button>
        </div>
    </form>
</x-guest-layout>