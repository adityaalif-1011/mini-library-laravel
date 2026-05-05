<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function showForm()
    {
        return view('auth.otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect('/login');
        }

        $user = User::find($userId);

        if ($user && $user->otp == $request->otp) {

            Auth::login($user);
            $user->update(['otp' => null]);
            session()->forget('otp_user_id');

            // PERBAIKAN: Redirect berdasarkan role
            if ($user->role === 'vendor') {
                return redirect()->route('vendor.dashboard');
            }

            // Default untuk customer
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah']);
    }
}