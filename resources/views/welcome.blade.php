<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pemesanan GOR Badminton</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 font-sans antialiased text-gray-900 selection:bg-emerald-500 selection:text-white">

    <nav class="bg-white border-b border-gray-100 shadow-sm fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        B
                    </div>
                    <span class="font-bold text-xl text-emerald-800 tracking-tight">E-Badminton</span>
                </div>
                <div>
                    @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-emerald-600 transition">Dasbor Anda</a>
                        @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-emerald-600 transition">Masuk</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-emerald-600 text-white px-4 py-2 rounded-lg shadow hover:bg-emerald-700 transition">Daftar Akun</a>
                        @endif
                        @endauth
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-24 pb-20 lg:pt-32 lg:pb-28 overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
                Pemesanan Lapangan <span class="text-emerald-600 text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Lebih Mudah & Cepat</span>
            </h1>
            <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto mb-10">
                Sistem manajemen GOR modern. Cek ketersediaan jadwal secara langsung, lakukan pemesanan dalam hitungan detik, dan kelola aktivitas olahraga Anda tanpa hambatan.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#katalog-lapangan" class="px-8 py-3 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg transition duration-200">
                    Lihat Lapangan
                </a>
                <a href="{{ route('login') }}" class="px-8 py-3 text-base font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition duration-200">
                    Masuk ke Sistem
                </a>
            </div>
        </div>
        <div class="absolute inset-y-0 w-full h-full bg-grid-slate-100/[0.04] bg-[bottom_1px_center] pointer-events-none" style="mask-image: linear-gradient(to bottom, transparent, black);"></div>
    </section>

    <section id="katalog-lapangan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900">Fasilitas Lapangan</h2>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">Pilih lapangan yang sesuai dengan preferensi Anda. Kami menyediakan fasilitas standar turnamen dengan pencahayaan optimal.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Pastikan variabel $lapangans dikirim dari Controller Anda --}}
                @forelse ($lapangans as $lapangan)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
                    <div class="h-48 bg-slate-200 flex items-center justify-center">
                        <span class="text-slate-400 font-medium">Foto {{ $lapangan->nama_lapangan }}</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-900">{{ $lapangan->nama_lapangan }}</h3>
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">Tersedia</span>
                            </div>
                            <p class="text-gray-500 text-sm mb-4">Lantai karpet standar BWF, pencahayaan merata, dan sirkulasi udara yang baik.</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-lg font-extrabold text-emerald-700">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}<span class="text-sm font-normal text-gray-500">/jam</span></span>
                            <a href="{{ route('booking.create', $lapangan->id) }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-800 transition">Pesan Sekarang &rarr;</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 font-medium">Data lapangan belum tersedia di dalam sistem.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 border-b border-gray-800 pb-12 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                            B
                        </div>
                        <span class="font-bold text-xl tracking-tight">E-Badminton</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Sistem manajemen pemesanan fasilitas olahraga berbasis teknologi untuk memudahkan pengelola dan pelanggan dalam bertransaksi.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-emerald-500 transition">Beranda</a></li>
                        <li><a href="#katalog-lapangan" class="hover:text-emerald-500 transition">Fasilitas Lapangan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-500 transition">Masuk Sistem</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Informasi Kontak</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-500">📍</span>
                            <span>Jl. Sistem Informasi No. 404, Kota Teknologi, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-emerald-500">📞</span>
                            <span>+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-emerald-500">✉️</span>
                            <span>admin@ebadminton.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} E-Badminton. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

</body>

</html>