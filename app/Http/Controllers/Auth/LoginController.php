<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect default (tidak dipakai karena kita override flow)
     */
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Method ini otomatis dipanggil setelah login berhasil
     */
    protected function authenticated($request, $user)
    {
        // 1️⃣ Generate OTP 6 digit angka
        $otp = rand(100000, 999999);

        // 2️⃣ Simpan OTP ke database
        $user->update([
            'otp' => $otp
        ]);

        // 3️⃣ Logout dulu supaya belum benar-benar login
        Auth::logout();

        // 4️⃣ Simpan ID user sementara di session
        session(['otp_user_id' => $user->id]);

        // 5️⃣ Kirim OTP ke email
        Mail::raw("Kode OTP login anda adalah: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode OTP Login');
        });

        // 6️⃣ Redirect ke halaman OTP
        return redirect()->route('otp.form');
    }
}
