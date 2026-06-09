<?php

namespace App\Http\Controllers;

// 1. WAJIB IMPORT SERVICE YANG SUDAH ANDA BUAT TADI
use App\Services\WhatsAppService; 
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $whatsappService;

    // 2. Inject Service ke dalam Constructor Controller
    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    // Contoh fungsi saat user berhasil melakukan sesuatu (misal: booking lapangan)
    public function kirimBuktiBooking()
    {
        // Nomor tujuan wajib pakai kode negara/angka depan yang valid (bisa 08xxx atau 628xxx)
        $nomorTujuan = '628123456789'; 
        
        // Isi pesan yang ingin dikirim
        $pesan = "Halo Andre, booking lapangan badminton Anda berhasil dikonfirmasi! 🏸";

        // 3. Eksekusi pengiriman via Fonnte
        $kirim = $this->whatsappService->sendMessage($nomorTujuan, $pesan);

        // 4. Cek status respons dari Fonnte
        if ($kirim['status']) {
            return response()->json([
                'success' => true, 
                'message' => 'Notifikasi WhatsApp berhasil dikirim!'
            ]);
        } else {
            return response()->json([
                'success' => false, 
                'message' => 'WhatsApp gagal dikirim: ' . $kirim['message']
            ], 500);
        }
    }
}