<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected ?string $token; // Ditambahkan tanda tanya (?) agar boleh null jika cache macet
    protected ?string $url;

    public function __construct()
    {
        // Sesuaikan dengan nama yang ada di file .env Anda
        $this->url   = env('WA_GATEWAY_URL') ?? 'https://api.fonnte.com/send';
        $this->token = env('FONNTE_TOKEN'); // <--- PASTI KAN MENGGUNAKAN 'FONNTE_TOKEN'
    }

    public function sendMessage(string $target, string $message)
    {
        try {
            // Sesuaikan struktur body JSON di bawah dengan dokumentasi API gateway Anda
            $response = Http::withHeaders([
                'Authorization' => $this->token, // Beberapa provider menggunakan header ini
            ])->post($this->url, [
                'target'  => $target,  // Nomor tujuan (misal: 628123456xxx)
                'message' => $message, // Isi pesan
                                       // 'token' => $this->token // Jika provider meminta token di dalam body
            ]);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data'   => $response->json(),
                ];
            }

            Log::error('WA Gateway Error: ' . $response->body());
            return [
                'status'  => false,
                'message' => 'Gagal mengirim pesan melalui provider.',
            ];

        } catch (\Exception $e) {
            Log::error('WA Service Exception: ' . $e->getMessage());
            return [
                'status'  => false,
                'message' => 'Terjadi kesalahan sistem.',
            ];
        }
    }
}
