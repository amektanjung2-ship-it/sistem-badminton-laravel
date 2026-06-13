<x-guest-layout>
    {{-- LAYER BACKGROUND PEMAIN BADMINTON --}}
    <div class="fixed inset-0 z-0 overflow-hidden bg-slate-950 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 via-slate-950/85 to-slate-900/75 z-10"></div>
        <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=2070&auto=format&fit=crop" 
             alt="Badminton Background" 
             class="w-full h-full object-cover object-center transform scale-105 filter blur-[1px]">
    </div>

    {{-- KOTAK FORM REGISTER MODERN --}}
    <div class="relative z-20 max-w-lg mx-auto bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] border border-white/40 text-gray-900 my-10">
        
        {{-- LOGO HURUF B MODERN (SERAGAM DENGAN WELCOME) --}}
        <div class="flex flex-col items-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 transform rotate-3 mb-4">
                <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 4H11C13.5 4 15.5 5.5 15.5 8C15.5 9.5 14.5 10.8 13 11.3C15 11.8 16.5 13.3 16.5 15.5C16.5 18.2 14.2 20 11.5 20H6V4Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 12H12.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Pendaftaran Akun Baru</h2>
            <p class="text-xs font-medium text-gray-500 mt-1">Lengkapi data diri untuk mulai berlangganan lapangan</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name" class="block font-bold text-xs uppercase tracking-wider text-gray-600 mb-1.5">{{ __('Nama Lengkap') }}</label>
                <input id="name" class="block w-full bg-slate-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm transition-all duration-200" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama sesuai KTP" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-5">
                <label for="email" class="block font-bold text-xs uppercase tracking-wider text-gray-600 mb-1.5">{{ __('Alamat Email') }}</label>
                <input id="email" class="block w-full bg-slate-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm transition-all duration-200" type="email" name="email" :value="old('email')" required placeholder="email@contoh.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-5">
                <label for="no_hp" class="block font-bold text-xs uppercase tracking-wider text-gray-600 mb-1.5">{{ __('Nomor WhatsApp') }}</label>
                <input id="no_hp" class="block w-full bg-slate-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm transition-all duration-200" type="text" name="no_hp" :value="old('no_hp')" required placeholder="Contoh: 62895xxxxx" />
                <span class="text-[10px] text-emerald-600 font-semibold mt-1.5 block leading-tight">*Gunakan kode negara (62) untuk notifikasi jadwal via WhatsApp.</span>
                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
            </div>

            <div class="mt-5">
                <label for="password" class="block font-bold text-xs uppercase tracking-wider text-gray-600 mb-1.5">{{ __('Password') }}</label>
                <div class="relative">
                    <input id="password" class="block w-full bg-slate-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm pr-12" type="password" name="password" required placeholder="••••••••" />
                    <button type="button" onclick="togglePassword('password', 'eye-open-pass', 'eye-close-pass')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none">
                        <svg id="eye-open-pass" class="h-5 w-5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg id="eye-close-pass" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10c3.5 4 14.5 4 18 0M6 12l-1.5 2.5M10 13l-0.5 3M14 13l0.5 3M18 12l1.5 2.5" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-5">
                <label for="password_confirmation" class="block font-bold text-xs uppercase tracking-wider text-gray-600 mb-1.5">{{ __('Konfirmasi Password') }}</label>
                <div class="relative">
                    <input id="password_confirmation" class="block w-full bg-slate-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm pr-12" type="password" name="password_confirmation" required placeholder="••••••••" />
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-open-confirm', 'eye-close-confirm')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none">
                        <svg id="eye-open-confirm" class="h-5 w-5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg id="eye-close-confirm" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10c3.5 4 14.5 4 18 0M6 12l-1.5 2.5M10 13l-0.5 3M14 13l0.5 3M18 12l1.5 2.5" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center items-center px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-emerald-700 hover:to-teal-700 transition-all duration-150 shadow-lg shadow-emerald-600/20">
                    {{ __('Daftar Akun Sekarang') }}
                </button>
            </div>
            
            <div class="text-center text-sm text-gray-500 border-t border-slate-100 pt-4 mb-4">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="font-extrabold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">Masuk di sini</a>
            </div>

            <div class="text-center text-xs font-bold text-gray-400 border-t border-slate-100 pt-3 tracking-wide uppercase">
                &copy; 2026 Sistem Pemesanan Fasilitas Olahraga
            </div>
        </form>
    </div>
</x-guest-layout>

<script>
function togglePassword(inputId, openIconId, closeIconId) {
    const passwordInput = document.getElementById(inputId);
    const openIcon = document.getElementById(openIconId);
    const closeIcon = document.getElementById(closeIconId);
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; openIcon.classList.replace('hidden', 'block'); closeIcon.classList.replace('block', 'hidden');
    } else {
        passwordInput.type = 'password'; openIcon.classList.replace('block', 'hidden'); closeIcon.classList.replace('hidden', 'block');
    }
}
document.addEventListener("DOMContentLoaded", function() {
    ['eye-open-pass', 'eye-open-confirm'].forEach(id => { const el = document.getElementById(id); if(el) el.classList.replace('block', 'hidden'); });
    ['eye-close-pass', 'eye-close-confirm'].forEach(id => { const el = document.getElementById(id); if(el) el.classList.replace('hidden', 'block'); });
});
</script>