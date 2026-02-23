@extends('layouts.auth')

@section('content')
<div class="container mt-5">
    <h3>Masukkan Kode OTP</h3>
<p>Email: {{ \App\Models\User::find(session('otp_user_id'))->email ?? '' }}</p>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="text" name="otp" maxlength="6" class="form-control mb-3" placeholder="Masukkan 6 digit OTP">
        <button type="submit" class="btn btn-primary">Verifikasi</button>
    </form>
</div>
@endsection
