<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Badminton</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans antialiased text-gray-900 p-4 sm:p-6">

    <div class="bg-white shadow-2xl border border-gray-100 rounded-2xl flex w-full max-w-5xl overflow-hidden min-h-[600px]">

        <div class="w-full lg:w-1/2 p-8 sm:p-12 flex flex-col justify-center bg-white relative z-10">
            
            <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-800 mb-8 transition duration-150 w-max">
                &larr; Kembali ke Beranda
            </a>

            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h2>
                <p class="text-sm text-gray-500 mt-2">Silakan masuk ke akun Anda untuk mulai memesan lapangan.</p>
            </div>

            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-md text-sm">
                <span class="font-bold">Gagal masuk!</span> Pastikan email dan kata sandi Anda benar.
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Lengkap</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150"
                        placeholder="contoh@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 transition duration-150">
                        <span class="ml-2 group-hover:text-gray-900 transition duration-150">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium transition duration-150">Lupa sandi?</a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 mt-6">
                    Masuk Sekarang
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-800 font-semibold transition duration-150">Daftar di sini</a>
            </p>
        </div>

        <div class="hidden lg:block lg:w-1/2 relative bg-gray-900">
            <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                 alt="Lapangan Badminton" 
                 class="absolute inset-0 w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-emerald-900/80 mix-blend-multiply"></div>
            
            <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-12">
                <div class="mb-8 p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                    </svg>
                </div>
                
                <h2 class="text-4xl font-extrabold text-white mb-4 tracking-tight leading-tight">
                    E-Badminton <br>
                    <span class="text-emerald-300 text-3xl">Sistem Reservasi GOR</span>
                </h2>
                
                <p class="text-emerald-100 text-lg leading-relaxed max-w-sm">
                    Pesan lapangan lebih cepat, pantau jadwal lebih akurat. Semua dalam satu genggaman.
                </p>
            </div>
        </div>

    </div>

</body>
</html>