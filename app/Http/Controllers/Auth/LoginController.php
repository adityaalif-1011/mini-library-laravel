<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {
        // Khusus vendor, redirect ke vendor dashboard
        if ($user->role === 'vendor') {
            return redirect('/vendor/dashboard');
        }
        
        // Customer tetap ke dashboard biasa
        return redirect('/dashboard');
    }
}