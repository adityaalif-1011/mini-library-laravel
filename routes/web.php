<?php

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\KantinOrderController;
use Midtrans\Snap;
use App\Http\Controllers\CustomerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return redirect('/login');
});

// ==================== AUTH ROUTES (OTP & GOOGLE) ====================
Auth::routes();

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::where('id_google', $googleUser->getId())->first();

    if (!$user) {
        $user = User::where('email', $googleUser->getEmail())->first();
        if ($user) {
            $user->update(['id_google' => $googleUser->getId()]);
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
    $user->update(['otp' => $otp]);
    session(['otp_user_id' => $user->id]);

    Mail::raw("Kode OTP login anda adalah: $otp", function ($message) use ($user) {
        $message->to($user->email)->subject('Kode OTP Login');
    });

    return redirect()->route('otp.form');
});

Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');

// ==================== ROUTE KHUSUS LOGIN VENDOR (TANPA OTP) ====================
Route::get('/login-vendor', function () {
    $user = App\Models\User::where('email', 'adityaalif1009@gmail.com')->first();
    
    if ($user && $user->role === 'vendor') {
        Auth::login($user);
        session()->forget('otp_user_id');
        $user->update(['otp' => null]);
        return redirect()->route('vendor.dashboard');
    }
    
    return redirect('/login')->with('error', 'Akun vendor tidak ditemukan');
})->name('login.vendor');

// ==================== ROUTES WITH AUTH MIDDLEWARE ====================
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');
    
    Route::resource('kategori', \App\Http\Controllers\KategoriController::class);
    Route::resource('buku', \App\Http\Controllers\BukuController::class);
    Route::resource('barangs', BarangController::class);
    Route::post('/barangs/cetak', [BarangController::class, 'cetak'])->name('barangs.cetak');
    Route::get('/pdf/sertifikat', [PdfController::class, 'sertifikat']);
    Route::get('/pdf/undangan', [PdfController::class, 'undangan']);
    Route::view('/modul4', 'modul4.index');
    Route::view('/modul5', 'modul5.index');
    Route::view('/modul5/pos', 'modul5.pos')->name('modul5.pos');
    
    // ==================== ORDER & PAYMENT ADMIN ====================
    Route::post('/order', [OrderController::class, 'store']);
    Route::get('/payment/{id}', [PaymentController::class, 'index']);
    Route::post('/payment/{id}', [PaymentController::class, 'pay']);
    Route::get('/payment/success/{id}', function($id){
        $pesanan = \App\Models\Pesanan::findOrFail($id);
        return view('payment.success', compact('pesanan'));
    });
    
    Route::get('/snap-token/{id}', function($id){
        $pesanan = \App\Models\Pesanan::findOrFail($id);
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $pesanan->id . '-' . time(),
                'gross_amount' => $pesanan->total,
            ],
        ];
        return Snap::getSnapToken($params);
    });
    
    // ==================== ROUTE VENDOR ====================
    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
        Route::post('/menu', [VendorController::class, 'storeMenu'])->name('menu.store');
        Route::delete('/menu/{id}', [VendorController::class, 'deleteMenu'])->name('menu.delete');
        Route::get('/menu', [VendorController::class, 'menuIndex'])->name('menu.index');
        Route::get('/pesanan', [VendorController::class, 'pesananLunas'])->name('pesanan');
    });
});

// ==================== FAKE API (TANPA AUTH) ====================
Route::get('/fake-api/barang/{kode}', function ($kode) {
    $data = [
        "B001" => ["nama" => "Marlong", "harga" => 2500],
        "B002" => ["nama" => "Surya", "harga" => 5000],
        "B003" => ["nama" => "Gajah Baru", "harga" => 3000],
    ];
    if(isset($data[$kode])){
        return response()->json($data[$kode]);
    }
    return response()->json(['message' => 'Not found'], 404);
});

Route::post('/fake-api/transaksi', function () {
    return response()->json(["status" => "success"]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ==================== CUSTOMER ROUTES (TANPA LOGIN) ====================
Route::get('/kantin/pos', function () {
    $vendors = App\Models\Vendor::all();
    return view('vendor.pos', compact('vendors'));
})->name('kantin.pos');

Route::get('/api/menus/{vendorId}', function($vendorId){
    return App\Models\Menu::where('vendor_id', $vendorId)->get();
});

Route::post('/kantin/order', [KantinOrderController::class, 'store']);
Route::get('/kantin/payment/{id}', [PaymentController::class, 'index']);
Route::post('/kantin/payment/{id}', [PaymentController::class, 'pay']);
Route::get('/kantin/success/{id}', function($id){
    $pesanan = App\Models\Pesanan::findOrFail($id);
    return view('payment.success', compact('pesanan'));
});

// ==================== TEMPORARY ROUTE UNTUK FIX ERROR (TIDAK MENGGANGGU LOGIN) ====================
Route::get('/vendor-login', function () {
    return redirect('/login');
})->name('vendor.login');

// Snap Token untuk customer
Route::get('/kantin/snap-token/{id}', function($id){
    $pesanan = App\Models\Pesanan::findOrFail($id);
    
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = false;
    
    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . $pesanan->id . '-' . time(),
            'gross_amount' => $pesanan->total,
        ],
    ];
    
    return \Midtrans\Snap::getSnapToken($params);
});

Route::get('/pesanan', [VendorController::class, 'pesananLunas'])->name('vendor.pesanan');

// ==================== ROUTE UNTUK FITUR CUSTOMER ====================

Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/customer/create-blob', [CustomerController::class, 'createBlob']);
Route::post('/customer/store-blob', [CustomerController::class, 'storeBlob']);
Route::get('/customer/create-file', [CustomerController::class, 'createFile']);
Route::post('/customer/store-file', [CustomerController::class, 'storeFile']);
Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
Route::put('/customer/{id}', [CustomerController::class, 'update']);