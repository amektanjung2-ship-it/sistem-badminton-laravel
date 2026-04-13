<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Booking - {{ $booking->lapangan->nama_lapangan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white p-8 text-gray-800" onload="window.print()"> 
    <div class="max-w-2xl mx-auto border-2 border-gray-800 p-8 rounded-xl">
        <div class="text-center border-b-2 border-gray-800 pb-4 mb-6">
            <h1 class="text-3xl font-bold uppercase tracking-widest text-green-700">GOR BADMINTON</h1>
            <p class="text-gray-500">Bukti Reservasi Lapangan Resmi</p>
        </div>

        <div class="flex justify-between mb-8">
            <div>
                <p class="text-sm">Nomor Pesanan:</p>
                <p class="font-bold text-lg">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm">Tanggal Cetak:</p>
                <p class="font-bold">{{ now()->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="mb-6">
            <p><strong>Nama Pemesan:</strong> {{ $booking->user->name }}</p>
            <p><strong>Lapangan:</strong> {{ $booking->lapangan->nama_lapangan }}</p>
            <p><strong>Jadwal:</strong> {{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d F Y') }} ({{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }})</p>
        </div>

        <div class="text-center mt-8 pt-4 border-t-2 border-dashed border-gray-400">
            <p class="text-2xl font-bold">TOTAL: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
            <p class="text-green-600 font-bold mt-1">STATUS: LUNAS</p>
        </div>
    </div>
</body>
</html>