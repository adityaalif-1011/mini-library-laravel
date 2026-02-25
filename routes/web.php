<?php

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PdfController;





Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::resource('kategori', \App\Http\Controllers\KategoriController::class);
    Route::resource('buku', \App\Http\Controllers\BukuController::class);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {

    $googleUser = Socialite::driver('google')->user();

    $user = User::where('id_google', $googleUser->getId())->first();

    if (!$user) {

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'id_google' => $googleUser->getId(),
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'id_google' => $googleUser->getId(),
                'password' => bcrypt('google-login'),
            ]);
        }
    }

    $otp = rand(100000, 999999);

    $user->update([
        'otp' => $otp
    ]);

    session(['otp_user_id' => $user->id]);

    Mail::raw("Kode OTP login anda adalah: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Kode OTP Login');
    });

    return redirect()->route('otp.form');
});



Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::get('/pdf/sertifikat', [PdfController::class, 'sertifikat']);
Route::get('/pdf/undangan', [PdfController::class, 'undangan']);