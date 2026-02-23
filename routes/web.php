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

    // 1️⃣ Cek berdasarkan id_google
    $user = User::where('id_google', $googleUser->getId())->first();

    if (!$user) {

        // 2️⃣ Kalau belum ada, cek berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // update id_google jika email sudah ada
            $user->update([
                'id_google' => $googleUser->getId(),
            ]);
        } else {
            // buat user baru
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

    // 4️⃣ SIMPAN USER ID KE SESSION (BELUM LOGIN)
    session(['otp_user_id' => $user->id]);

    // 5️⃣ KIRIM EMAIL OTP
    Mail::raw("Kode OTP login anda adalah: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Kode OTP Login');
    });

    // 6️⃣ REDIRECT KE HALAMAN OTP
    return redirect()->route('otp.form');
});



Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::get('/pdf/sertifikat', [PdfController::class, 'sertifikat']);
Route::get('/pdf/undangan', [PdfController::class, 'undangan']);