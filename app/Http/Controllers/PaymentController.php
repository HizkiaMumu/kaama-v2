<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function getSnapToken()
    {
        // Set Midtrans configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Order details
        $order_id = "ORDER-" . time();
        $gross_amount = 10000; // Example: 10,000 IDR

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $gross_amount,
            ],
            'payment_type' => 'qris'
        ];

        try {
            // Generate Snap token
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
