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
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Kata Sandi') }}</label>
            <input id="password" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors duration-200"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Konfirmasi Kata Sandi') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors duration-200"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
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