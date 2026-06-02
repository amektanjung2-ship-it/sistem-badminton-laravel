<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Login</title>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center"
style="background-image:url('https://images.unsplash.com/photo-1626224583764-f87db24ac4ea');">

<div class="absolute inset-0 bg-black/50"></div>

<div class="relative z-10 bg-white/90 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-full max-w-md">

    <h1 class="text-3xl font-bold text-center text-green-600 mb-2">
        🏸 E-Badminton
    </h1>

    <p class="text-center text-gray-500 mb-6">
        Sistem Booking Lapangan Badminton
    </p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label>Email</label>
            <input type="email"
                name="email"
                class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password"
                name="password"
                class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-green-500">
        </div>

        <button
            class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-green-700 transition duration-300">
            Login
        </button>
    </form>

</div>

</body>
</html>