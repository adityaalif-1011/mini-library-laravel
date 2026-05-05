@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                
                                <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mt-2">
                                    Login with Google
                                </a>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <!-- ========== OPSI VENDOR ========== -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-2">🔐 Akses khusus vendor:</p>
                        
                        <!-- TOMBOL LANGSUNG LOGIN VENDOR (TANPA OTP) -->
                        <div class="row mb-2">
                            <div class="col-md-6 offset-md-3">
                                <a href="{{ route('login.vendor') }}" class="btn btn-success btn-sm w-100" 
                                   style="background-color: #28a745; border-color: #28a745;">
                                    🏪 Login sebagai Vendor (Langsung)
                                </a>
                            </div>
                        </div>
                        
                        <p class="text-muted small mb-1">atau</p>
                        <a href="{{ route('vendor.login') }}" class="btn btn-success btn-sm w-100" 
   style="background-color: #28a745; border-color: #28a745;">
    🏪 Login sebagai Vendor (Langsung)
</a>
                        
                        <!-- TOMBOL ISI MANUAL -->
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <a href="#" class="btn btn-outline-success btn-sm w-100" 
                                   onclick="fillVendorCreds()">
                                    Isi Email & Password Vendor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillVendorCreds() {
    document.getElementById('email').value = 'adityaalif1009@gmail.com';
    document.getElementById('password').value = '12345678';
}
</script>
@endsection