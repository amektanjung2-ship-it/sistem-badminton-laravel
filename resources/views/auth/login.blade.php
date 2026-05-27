<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Masuk ke Sistem</h2>
        <p class="text-sm text-gray-500 mt-2">Silakan masukkan kredensial Anda untuk mengakses layanan</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Alamat Email') }}</label>
            <input id="email" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@ebadminton.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5">
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Kata Sandi') }}</label>
            <input id="password" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm transition-colors duration-200"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-emerald-600 hover:text-emerald-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                {{ __('Masuk') }}
            </button>
        </div>
        
        @if (Route::has('register'))
        <div class="mt-6 text-center text-sm text-gray-600 border-t border-gray-100 pt-6">
            Belum memiliki akun pelanggan? 
            <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-800 hover:underline transition-colors">Daftar sekarang</a>
        </div>
        @endif
    </form>
</x-guest-layout>