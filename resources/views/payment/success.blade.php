
<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
</head>
<body style="text-align:center; margin-top:50px;">

    <h2>Pembayaran Berhasil 🎉</h2>

    <p>ID Pesanan: {{ $pesanan->id }}</p>

    <h4>QR Code:</h4>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $pesanan->id }}" alt="QR Code">
    <p>Silahkan tunjukkan QR ini ke vendor</p>

</body>
</html>