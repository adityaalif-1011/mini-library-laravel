<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
{
    if (!$request->items || count($request->items) == 0) {
        return response()->json([
            'error' => 'Items kosong'
        ], 400);
    }

    $nama = 'Guest_' . str_pad(DB::table('pesanans')->count()+1, 7, '0', STR_PAD_LEFT);

    $pesanan = \App\Models\Pesanan::create([
        'nama_customer' => $nama,
        'total' => $request->total,
        'status' => 'pending'
    ]);

    foreach ($request->items as $item) {
        \App\Models\DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'barang_id' => $item['id'],
            'qty' => $item['qty'],
            'harga' => $item['harga'],
            'subtotal' => $item['harga'] * $item['qty']
        ]);
    }

    return response()->json([
        'pesanan_id' => $pesanan->id
    ]);
}
}
