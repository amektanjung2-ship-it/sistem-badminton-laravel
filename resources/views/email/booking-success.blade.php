<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Booking</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; rounded: 8px;">
        <h2 style="color: #059669;">Halo, {{ $booking->user->name }}!</h2>
        <p>Terima kasih telah melakukan pemesanan lapangan di aplikasi kami. Berikut adalah rincian booking Anda:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Kode Booking:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">#{{ $booking->id }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Tanggal:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $booking->tanggal }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Waktu:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $booking->jam_mulai }} WIB</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Total Bayar:</td>
                <td style="padding: 8px; border-bottom: 1px solid #eee; color: #dc2626; font-weight: bold;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>

        <p>Silakan lakukan pembayaran atau konfirmasi ke admin jika diperlukan. Selamat berolahraga!</p>
    </div>
</body>
</html>