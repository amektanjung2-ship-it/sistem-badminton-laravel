<x-guest-layout>
    {{-- LAYER BACKGROUND PEMAIN BADMINTON --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-slate-950 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 via-slate-950/85 to-slate-900/75 z-10"></div>
        <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=2070&auto=format&fit=crop" 
             alt="Badminton Background" 
             class="w-full h-full object-cover object-center transform scale-105 filter blur-[1px]">
    </div>

    {{-- KOTAK TABEL LOGIN MODERN --}}
    <div class="relative z-20 max-w-md mx-auto bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] border border-white/40 text-gray-900 transform transition-all duration-300">
        
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- LOGO HURUF B MODERN (SERAGAM DENGAN WELCOME) --}}
        <div class="flex flex-col items-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 transform -rotate-6 mb-4">
                <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 4H11C13.5 4 15.5 5.5 15.5 8C15.5 9.5 14.5 10.8 13 11.3C15 11.8 16.5 13.3 16.5 15.5C16.5 18.2 14.2 20 11.5 20H6V4Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 12H12.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h2 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-700 tracking-tight">Masuk ke Sistem</h2>
            <p class="text-xs font-medium text-gray-500 mt-1">Gunakan akun Anda untuk mengakses layanan GOR</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block font-bold text-xs uppercase tracking-wider text-gray-600 mb-1.5">{{ __('Alamat Email') }}</label>
                <input id="email" class="block w-full bg-slate-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-gray-900 font-medium transition duration-200" type="email" name="email" :value="old('email')" required autofocus placeholder="admin@gmail.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-5">
                <label for="password" class="block font-bold text-xs uppercase tracking-wider text-gray-600 mb-1.5">{{ __('Kata Sandi') }}</label>
                <input id="password" class="block w-full bg-slate-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-gray-900 font-medium transition duration-200" type="password" name="password" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded-md border-gray-200 text-emerald-600 shadow-sm focus:ring-emerald-500 cursor-pointer" name="remember">
                    <span class="ms-2 text-sm text-gray-500 font-medium hover:text-gray-700 transition">{{ __('Ingat Saya') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition" href="{{ route('password.request') }}">{{ __('Lupa kata sandi?') }}</a>
                @endif
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full flex justify-center items-center px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-emerald-700 hover:to-teal-700 transition duration-150 shadow-lg shadow-emerald-600/20">
                    {{ __('MASUK') }}
                </button>
            </div>
            
            @if (Route::has('register'))
            <div class="text-center text-sm text-gray-500 border-t border-slate-100 pt-4 mb-4">
                Belum memiliki akun? <a href="{{ route('register') }}" class="font-extrabold text-emerald-600 hover:text-emerald-700 hover:underline transition">Daftar Sekarang</a>
            </div>
            @endif

            <div class="text-center text-xs font-bold text-gray-400 border-t border-slate-100 pt-3 tracking-wide uppercase">
                &copy; 2026 Sistem Pemesanan Fasilitas Olahraga
            </div>
        </form>
    </div>
</x-guest-layout>