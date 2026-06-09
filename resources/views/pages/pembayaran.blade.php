<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Booking #{{ $booking->id }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-6 rounded-2xl shadow-lg max-w-md w-full border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 text-center mb-4 text-emerald-600 flex items-center justify-center gap-2">
            🏸 Detail Pembayaran Lapangan
        </h2>
        
        <hr class="border-gray-200 my-3">

        <div class="space-y-3 text-sm text-gray-700">
            <div class="flex justify-between">
                <span class="text-gray-500">Nama Lapangan:</span>
                <span class="font-semibold">{{ $booking->lapangan->nama_lapangan }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal Main:</span>
                <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Jadwal Jam:</span>
                <span class="font-semibold text-amber-600">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</span>
            </div>
            <div class="flex justify-between p-3 bg-emerald-50 rounded-lg border border-emerald-100 mt-4">
                <span class="text-emerald-700 font-bold">Total Tagihan:</span>
                <span class="text-emerald-700 font-bold text-base">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-6">
            <button id="pay-button" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition duration-200 cursor-pointer text-center">
                Bayar Sekarang (QRIS / Bank Transfer)
            </button>
            <p class="text-xs text-gray-400 text-center mt-2">Klik tombol di atas untuk memunculkan Barcode QRIS atau metode pembayaran lainnya.</p>
        </div>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Memicu pop-up Snap Midtrans menggunakan token yang dikirim dari controller
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    /* Anda bisa arahkan ke halaman sukses */
                    alert("Pembayaran berhasil!"); console.log(result);
                    window.location.href = "{{ route('dashboard') }}";
                },
                onPending: function(result){
                    /* Pembayaran pending (misal menunggu scan QRIS/transfer bank) */
                    alert("Menunggu pembayaran Anda!"); console.log(result);
                },
                onError: function(result){
                    /* Pembayaran gagal */
                    alert("Pembayaran gagal!"); console.log(result);
                },
                onClose: function(){
                    /* Ketika pelanggan menutup pop-up sebelum selesai */
                    alert('Anda menutup halaman pembayaran sebelum menyelesaikan transaksi.');
                }
            });
        });
    </script>
</body>
</html>