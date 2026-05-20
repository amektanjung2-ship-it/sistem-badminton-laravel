<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Badminton | Sistem Manajemen Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <!-- Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <span class="font-bold text-2xl text-emerald-700 tracking-tight">E-Badminton</span>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900 transition duration-150">
                                Masuk Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition duration-150">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition duration-150">
                                    Daftar Akun
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="pt-28 pb-16 lg:pt-36 flex items-center justify-center min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium text-emerald-800 bg-emerald-50 mb-8 border border-emerald-200">
                Sistem Manajemen Lapangan V.1.0
            </div>

            <!-- Headline -->
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-6 leading-tight">
                Efisiensi Manajemen <br class="hidden md:block">
                <span class="text-emerald-600">Gelanggang Olahraga Anda.</span>
            </h1>

            <!-- Sub-headline -->
            <p class="mt-4 text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform penyewaan lapangan bulu tangkis yang terintegrasi. Kelola ketersediaan jadwal, transaksi, dan inventaris perlengkapan secara real-time dan profesional.
            </p>

            <!-- Call to Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 text-base font-semibold rounded-md text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition duration-150">
                        Akses Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-3 text-base font-semibold rounded-md text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition duration-150">
                        Mulai Booking
                    </a>
                    <a href="#fitur" class="px-8 py-3 text-base font-semibold rounded-md text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition duration-150">
                        Pelajari Fitur
                    </a>
                @endauth
            </div>

            <!-- Dashboard Preview Image -->
            <div class="mt-16 mx-auto w-full max-w-5xl rounded-lg shadow-xl border border-gray-200 overflow-hidden bg-white">
                <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Pratinjau Sistem E-Badminton" class="w-full h-auto object-cover">
            </div>

        </div>
    </main>

</body>
</html>