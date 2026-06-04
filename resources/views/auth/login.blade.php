```html
<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Login - E-Badminton</title>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center"
style="background-image:url('https://images.unsplash.com/photo-1626224583764-f87db24ac4ea');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Login Card -->
    <div class="relative z-10 bg-white/90 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-full max-w-md animate-fade-in">

        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-4xl shadow-md">
                🏸
            </div>
        </div>

        <h1 class="text-3xl font-bold text-center text-green-600 mb-2">
            E-Badminton
        </h1>

        <p class="text-center text-gray-500 mb-6">
            Sistem Booking Lapangan Badminton
        </p>

        <!-- Error Login -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-3 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="font-medium">Email</label>
                <input
                    type="email"
                    name="email"
                    required
                    class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="font-medium">Password</label>

                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-green-500">

                    <button
    type="button"
    onclick="togglePassword()"
    class="absolute right-3 top-4 text-gray-500 hover:text-green-600">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-5 w-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5
              c4.477 0 8.268 2.943 9.542 7
              -1.274 4.057-5.065 7-9.542 7
              -4.477 0-8.268-2.943-9.542-7z"/>
    </svg>

</button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-5">
                <input
                    type="checkbox"
                    name="remember"
                    class="mr-2 rounded border-gray-300">

                <label class="text-sm text-gray-700">
                    Ingat Saya
                </label>
            </div>

            <!-- Login Button -->
            <button
                type="submit"
                class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-green-700 transition duration-300 font-semibold shadow-md">
                Login
            </button>

            <!-- Register -->
            <p class="text-center mt-5 text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="text-green-600 font-bold hover:underline">
                    Daftar Sekarang
                </a>
            </p>
        </form>

        <!-- Footer -->
        <div class="mt-6 border-t pt-4">
            <p class="text-center text-xs text-gray-500">
                © 2026 E-Badminton Booking System
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            let password = document.getElementById('password');

            if (password.type === 'password') {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        }
    </script>

</body>
</html>
```
