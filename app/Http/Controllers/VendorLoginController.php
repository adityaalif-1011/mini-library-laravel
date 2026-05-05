<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VendorLoginController extends Controller
{
    public function login()
    {
        dd("Vendor Login dipanggil");
        // Cari user vendor
        $user = User::where('email', 'adityaalif1009@gmail.com')->first();
        
        if ($user && $user->role === 'vendor') {
            // Logout dulu jika ada user yang login
            if (Auth::check()) {
                Auth::logout();
            }
            
            // Bersihkan semua session
            session()->flush();
            
            // Login sebagai vendor
            Auth::login($user);
            
            // Redirect ke vendor dashboard
            return redirect()->route('vendor.dashboard');
        }
        
        return redirect('/login')->with('error', 'Akun vendor tidak ditemukan');
    }
}