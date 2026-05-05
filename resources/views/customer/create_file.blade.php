@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Tambah Customer (FILE)</h3>

    <form method="POST" action="/customer/store-file">
        @csrf

        <!-- DATA -->
        <input type="text" name="nama" placeholder="Nama" class="form-control my-2" required>
        <input type="text" name="alamat" placeholder="Alamat" class="form-control my-2">

        <input type="text" name="provinsi" placeholder="Provinsi" class="form-control my-2">
        <input type="text" name="kota" placeholder="Kota" class="form-control my-2">
        <input type="text" name="kecamatan" placeholder="Kecamatan" class="form-control my-2">
        <input type="text" name="kelurahan" placeholder="Kelurahan" class="form-control my-2">

        <!-- BUTTON CAMERA -->
        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#cameraModal">
            Ambil Foto
        </button>

        <br><br>

        <!-- PREVIEW -->
        <img id="preview" style="width:150px; height:150px; object-fit:cover; border-radius:12px; border:1px solid #ddd;">

        <!-- HIDDEN -->
        <input type="hidden" name="foto" id="foto">

        <br><br>

        <button class="btn btn-success">Simpan Data</button>
    </form>

</div>

<!-- MODAL -->
<div class="modal fade" id="cameraModal">
  <div class="modal-dialog">
    <div class="modal-content p-3">

        <video id="video" width="100%" autoplay></video>
        <canvas id="canvas" style="display:none;"></canvas>

        <img id="snapshot" width="100%" class="mt-2"/>

        <button onclick="capture()" class="btn btn-primary mt-2">Ambil Foto</button>
        <button onclick="savePhoto()" class="btn btn-success mt-2">Simpan Foto</button>

    </div>
  </div>
</div>

<script>
let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let snapshot = document.getElementById('snapshot');

// buka kamera
navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    video.srcObject = stream;
})
.catch(err => {
    alert("Kamera tidak bisa diakses");
});

// capture
function capture() {
    let ctx = canvas.getContext('2d');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    ctx.drawImage(video, 0, 0);

    let data = canvas.toDataURL('image/png');
    snapshot.src = data;
}

// simpan ke form
function savePhoto() {
    let data = snapshot.src;

    if (!data) {
        alert("Ambil foto dulu!");
        return;
    }

    document.getElementById('foto').value = data;
    document.getElementById('preview').src = data;
}
</script>

@endsection