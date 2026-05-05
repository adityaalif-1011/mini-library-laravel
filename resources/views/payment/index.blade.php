<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>

    <!-- Bootstrap (optional biar rapi) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="Mid-client-Zun4_lWemKnTEQiF"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body text-center">

            <h3 class="mb-4">Halaman Pembayaran</h3>

            <hr>

            <p><strong>Nama Customer:</strong> {{ $pesanan->nama_customer }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>

            <p>
                <strong>Status:</strong>
                @if($pesanan->status == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @else
                    <span class="badge bg-success">Lunas</span>
                @endif
            </p>

            <hr>

            @if($pesanan->status == 'pending')
                <button id="btnBayar" class="btn btn-success btn-lg">
                    Bayar Sekarang
                </button>
            @else
                <h5 class="text-success">Pembayaran sudah selesai</h5>
            @endif

        </div>
    </div>
</div>

<script>
document.getElementById('btnBayar')?.addEventListener('click', function () {

    snap.pay('{{ $snapToken }}', {

        onSuccess: function(result){
            alert("Pembayaran berhasil!");

            // update ke database
            fetch("/payment/{{ $pesanan->id }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            }).then(() => {
                window.location.href = "/modul5/pos";
            });
        },

        onPending: function(result){
            alert("Menunggu pembayaran");
        },

        onError: function(result){
            alert("Pembayaran gagal");
            console.log(result);
        }

    });

});
</script>

</body>
</html>