<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan GOR</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #059669;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #059669;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #555;
        }
        .summary-box {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .summary-box td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background-color: #f8fafc;
        }
        .summary-box strong {
            display: block;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-box span {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #059669;
            color: #ffffff;
            font-size: 11px;
            text-transform: uppercase;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            font-style: italic;
            color: #64748b;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Pendapatan GOR Badminton</h2>
        <p>
            Periode Laporan: 
            @if($start_date && $end_date)
                {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}
            @else
                Keseluruhan Waktu
            @endif
        </p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <strong>Total Keseluruhan</strong>
                <span>Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</span>
            </td>
            <td>
                <strong>Pendapatan Lapangan</strong>
                <span>Rp {{ number_format($total_lapangan, 0, ',', '.') }}</span>
            </td>
            <td>
                <strong>Pendapatan Sewa/Jual Alat</strong>
                <span>Rp {{ number_format($total_alat, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="20%">Pelanggan</th>
                <th width="25%">Lapangan</th>
                <th width="20%">Jadwal Main</th>
                <th width="15%">Tagihan Lapangan</th>
                <th width="15%">Total Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $booking->user->name ?? 'User Terhapus' }}</td>
                    <td>{{ $booking->lapangan->nama_lapangan ?? 'Lapangan Terhapus' }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->tanggal_main)->format('d-m-Y') }}<br>
                        <small>{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</small>
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($booking->lapangan->harga_per_jam * $booking->durasi ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi lunas pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak otomatis dari Sistem E-Badminton pada {{ now()->translatedFormat('d F Y, H:i') }} WIB.
    </div>

</body>
</html>