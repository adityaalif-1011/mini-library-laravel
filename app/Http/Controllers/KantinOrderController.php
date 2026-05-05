<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;

class KantinOrderController extends Controller
{
    public function store(Request $request)
    {
        // Generate Guest ID (sama seperti admin)
        $nama = 'Guest_' . str_pad(Pesanan::count() + 1, 7, '0', STR_PAD_LEFT);

        // Simpan ke tabel pesanans (pakai nama_customer, bukan customer_name)
        $pesanan = Pesanan::create([
            'nama_customer' => $nama,
            'total' => $request->total,
            'status' => 'pending'
        ]);

        // Simpan detail pesanan (pakai menu_id)
        foreach ($request->items as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $item['menu_id'],
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