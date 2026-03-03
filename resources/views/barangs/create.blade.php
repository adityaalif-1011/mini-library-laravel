<h2>Tambah Barang</h2>

<form action="{{ route('barangs.store') }}" method="POST">
@csrf

Nama Barang:
<input type="text" name="nama_barang"><br>

Harga:
<input type="number" name="harga"><br>

<button type="submit">Simpan</button>
</form>