<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Midtrans\Snap;
use Midtrans\Config;
use Endroid\QrCode\QrCode; 
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class KantinPaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $pesanan->id . '-' . time(),
                'gross_amount' => $pesanan->total,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama_customer,
            ],
        ];

        return Snap::getSnapToken($params);
    }

    public function pay($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        if ($pesanan->status == 'pending') {
            $pesanan->update(['status' => 'lunas']);
        }
        
        return response()->json(['status' => 'success']);
    }



public function success($id)
{
    $pesanan = Pesanan::findOrFail($id);

    $result = Builder::create()
        ->writer(new PngWriter())
        ->data((string) $pesanan->id)
        ->size(200)
        ->build();

    $qr = base64_encode($result->getString());

    return view('payment.success', compact('pesanan', 'qr'));
}
}