<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Vendor;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class VendorController extends Controller
{
    public function dashboard()
    {
        // Cek apakah user yang login adalah vendor
        if (Auth::user()->role !== 'vendor') {
            abort(403, 'Akses hanya untuk vendor');
        }

        $vendor = Vendor::where('user_id', Auth::id())->first();
        $menus = Menu::where('vendor_id', $vendor->id)->get();

        return view('vendor.dashboard', compact('vendor', 'menus'));
    }

    public function storeMenu(Request $request)
    {
        if (Auth::user()->role !== 'vendor') {
            abort(403);
        }

        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric|min:1000',
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->first();

        Menu::create([
            'vendor_id' => $vendor->id,
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
        ]);

        return back()->with('success', 'Menu ditambahkan');
    }

    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $vendor = Vendor::where('user_id', Auth::id())->first();

        if ($menu->vendor_id == $vendor->id) {
            $menu->delete();
        }

        return back()->with('success', 'Menu dihapus');
    }

    public function menuIndex()
    {
    if (Auth::user()->role !== 'vendor') {
        abort(403, 'Akses hanya untuk vendor');
    }

    $vendor = Vendor::where('user_id', Auth::id())->first();
    $menus = Menu::where('vendor_id', $vendor->id)->get();

    return view('vendor.menu', compact('vendor', 'menus'));
    }
public function pesananLunas()
{
    if (Auth::user()->role !== 'vendor') {
        abort(403, 'Akses hanya untuk vendor');
    }

    $vendor = Vendor::where('user_id', Auth::id())->first();
    
    // Ambil semua pesanan dengan status 'paid'
    $pesananLunas = Pesanan::where('status', 'lunas')
        ->latest()
        ->get();
    
    return view('vendor.pesanan', compact('pesananLunas', 'vendor'));
}
}