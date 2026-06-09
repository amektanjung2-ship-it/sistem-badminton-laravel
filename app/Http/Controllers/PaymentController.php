<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        // Setup konfigurasi Midtrans
        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        // Data transaksi
        $params = [
            'transaction_details' => [
                'order_id'     => 'ORDER-' . time(), // ID unik tiap transaksi
                'gross_amount' => 50000,             // Harga dalam rupiah
            ],
            'customer_details' => [
                'first_name' => $request->name  ?? 'Customer',
                'email'      => $request->email ?? 'customer@email.com',
                'phone'      => $request->phone ?? '08123456789',
            ],
        ];

        // Ambil Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        return view('checkout', compact('snapToken'));
    }
}