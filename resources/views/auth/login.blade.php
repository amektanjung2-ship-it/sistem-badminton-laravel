<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem GOR Badminton</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-2xl rounded-2xl flex w-full max-w-4xl overflow-hidden">
        
        <div class="w-full lg:w-1/2 p-8 md:p-12">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Selamat Datang 👋</h2>
                <p class="text-sm text-gray-500 mt-2">Silakan masuk ke akun Anda untuk mulai memesan lapangan.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    <strong>Gagal masuk!</strong> Email atau password Anda salah.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Lengkap</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full mt-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition duration-200"
                        placeholder="contoh@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full mt-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition duration-200"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="ml-2">Ingat saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700 font-medium transition">Lupa sandi?</a>
                    @endif
                </div>

                <button type="submit" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition duration-200 uppercase tracking-wider text-sm mt-6">
                    Masuk Sekarang
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 font-bold transition">Daftar di sini</a>
            </p>
        </div>

        <div class="hidden lg:block w-1/2 relative bg-green-700 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-green-600 rounded-full opacity-50 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-green-800 rounded-full opacity-50 blur-3xl"></div>
            
            <div class="absolute inset-0 flex flex-col justify-center items-center text-white px-12 z-10 text-center">
                <div class="w-24 h-24 mb-6 bg-white bg-opacity-20 backdrop-blur-lg rounded-full flex items-center justify-center shadow-2xl">
                    <span class="text-5xl">🏸</span>
                </div>
                <h2 class="text-4xl font-bold mb-4">Sistem Reservasi<br>GOR Badminton</h2>
                <p class="text-green-100 text-lg">Pesan lapangan dengan mudah, cepat, dan transparan tanpa perlu antre di tempat.</p>
            </div>
        </div>

    </div>

</body>
</html>