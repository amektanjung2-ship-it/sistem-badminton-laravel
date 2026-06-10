<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Pendaftaran Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-2">Lengkapi data diri Anda di bawah ini untuk mulai menggunakan layanan kami</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nama Lengkap') }}</label>
            <input id="name" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors duration-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Alamat Email') }}</label>
            <input id="email" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors duration-200" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="no_hp" class="block font-medium text-sm text-gray-700">{{ __('Nomor WhatsApp (Aktif)') }}</label>
            <input id="no_hp" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors duration-200" type="text" name="no_hp" :value="old('no_hp')" required placeholder="Contoh: 62895xxxxx" />
            <span class="text-xs text-gray-400 mt-1 block">*Gunakan kode negara (misal: 62895...) untuk integrasi WhatsApp.</span>
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
            <div class="relative mt-1">
                <input id="password" class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm pr-10" type="password" name="password" required autocomplete="new-password" />
                       
                <button type="button" onclick="togglePassword('password', 'eye-open-pass', 'eye-close-pass')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-emerald-600 transition-colors duration-200 focus:outline-none">
                    <svg id="eye-open-pass" class="h-5 w-5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-close-pass" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10c3.5 4 14.5 4 18 0M6 12l-1.5 2.5M10 13l-0.5 3M14 13l0.5 3M18 12l1.5 2.5" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
            <div class="relative mt-1">
                <input id="password_confirmation" class="block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm pr-10" type="password" name="password_confirmation" required />
                       
                <button type="button" onclick="togglePassword('password_confirmation', 'eye-open-confirm', 'eye-close-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-emerald-600 transition-colors duration-200 focus:outline-none">
                    <svg id="eye-open-confirm" class="h-5 w-5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-close-confirm" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10c3.5 4 14.5 4 18 0M6 12l-1.5 2.5M10 13l-0.5 3M14 13l0.5 3M18 12l1.5 2.5" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                {{ __('Daftar Akun') }}
            </button>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-600 border-t border-gray-100 pt-6">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-800 hover:underline transition-colors">Masuk di sini</a>
        </div>
        
    </form>
</x-guest-layout>

<script>
function togglePassword(inputId, openIconId, closeIconId) {
    const passwordInput = document.getElementById(inputId);
    const openIcon = document.getElementById(openIconId);
    const closeIcon = document.getElementById(closeIconId);

    // Dibalik logikanya agar saat pertama kali dimuat (type=password), ikon yang tampil adalah mata terpejam (closeIcon)
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        openIcon.classList.remove('hidden');
        openIcon.classList.add('block');
        
        closeIcon.classList.remove('block');
        closeIcon.classList.add('hidden');
    } else {
        passwordInput.type = 'password';
        openIcon.classList.remove('block');
        openIcon.classList.add('hidden');
        
        closeIcon.classList.remove('hidden');
        closeIcon.classList.add('block');
    }
}

// Inisialisasi awal agar saat halaman web dibuka, ikon mata merem yang langsung muncul
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('eye-open-pass').classList.replace('block', 'hidden');
    document.getElementById('eye-close-pass').classList.replace('hidden', 'block');
    document.getElementById('eye-open-confirm').classList.replace('block', 'hidden');
    document.getElementById('eye-close-confirm').classList.replace('hidden', 'block');
});
</script>