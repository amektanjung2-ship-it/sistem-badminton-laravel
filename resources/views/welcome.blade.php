<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Badminton | Pesan Lapangan Tanpa Ribet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-gray-900">

    <nav class="bg-white shadow-sm fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span class="text-3xl">🏸</span>
                    <span class="font-bold text-2xl text-emerald-600 tracking-tight">E-Badminton</span>
                </div>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-800 transition">Masuk Dashboard &rarr;</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition">Daftar Akun</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="relative pt-24 pb-16 lg:pt-36 flex items-center justify-center min-h-screen overflow-hidden">
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-emerald-800 bg-emerald-100 mb-6">
                <span class="flex w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                Sistem Manajemen Lapangan V.1.0
            </div>
            
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-6 leading-tight">
                Stop Catat Manual. <br class="hidden md:block">
                Mulai Digitalisasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">Gor Kamu.</span>
            </h1>
            
            <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform penyewaan lapangan bulu tangkis yang cerdas. Bebas antre, bebas jadwal bentrok, dan pantau stok perlengkapan secara real-time.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 text-lg font-bold rounded-full text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-1">
                        Pesan Lapangan Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 text-lg font-bold rounded-full text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-1">
                        Mulai Booking Sekarang
                    </a>
                    <a href="#fitur" class="px-8 py-4 text-lg font-bold rounded-full text-gray-700 bg-white border-2 border-gray-200 hover:border-emerald-500 hover:text-emerald-600 transition">
                        Lihat Fitur
                    </a>
                @endauth
            </div>

            <div class="mt-16 mx-auto w-full max-w-4xl rounded-2xl shadow-2xl border border-gray-100 overflow-hidden bg-white">
                <div class="h-8 bg-gray-100 border-b border-gray-200 flex items-center px-4 gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                </div>
                <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Dashboard Preview" class="w-full h-auto object-cover opacity-90 hover:opacity-100 transition duration-500">
            </div>
        </div>
    </main>

</body>
</html>