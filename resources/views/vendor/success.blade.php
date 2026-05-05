@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center py-5">

```
                <!-- ICON SUCCESS -->
                <i class="mdi mdi-check-circle-outline text-success" style="font-size: 80px;"></i>

                <!-- TITLE -->
                <h2 class="mt-3">Pembayaran Berhasil! ✅</h2>

                <!-- INFO CUSTOMER -->
                <p class="mt-3">
                    Terima kasih, <strong>{{ $pesanan->nama_customer }}</strong>
                </p>

                <!-- TOTAL -->
                <p>
                    Total pembayaran: 
                    <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong>
                </p>

                <hr>

                <!-- QR CODE -->
                <div class="my-4">
                    <h5>QR Pesanan</h5>

                    <img src="data:image/png;base64,{{ $qr }}" width="200">

                    <p class="mt-2 text-muted">
                        Tunjukkan QR ini saat pengambilan pesanan
                    </p>
                </div>

                <hr>

                <!-- ACTION BUTTON -->
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('kantin.pos') }}" class="btn btn-primary">
                        <i class="mdi mdi-cart"></i> Pesan Lagi
                    </a>

                    <a href="{{ route('vendor.dashboard') }}" class="btn btn-secondary">
                        <i class="mdi mdi-home"></i> Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
```

</div>
@endsection
