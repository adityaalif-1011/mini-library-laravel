<?php

namespace App\Http\Controllers;
use Midtrans\Snap;
use App\Models\Pesanan;

class PaymentController extends Controller
{
    public function index($id)
{
    $pesanan = Pesanan::findOrFail($id);

    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . $pesanan->id . '-' . time(),
            'gross_amount' => $pesanan->total,
        ],
        'customer_details' => [
            'first_name' => $pesanan->nama_customer,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    return view('payment.index', compact('pesanan', 'snapToken'));
}

    public function pay($id)
{
    $pesanan = Pesanan::findOrFail($id);

    if ($pesanan->status == 'pending') {
        $pesanan->update([
            'status' => 'lunas'
        ]);
    }

    return response()->json([
        'status' => 'success'
    ]);
}
}