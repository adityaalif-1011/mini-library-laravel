<h2>Edit Barang</h2>

<form action="{{ route('barangs.update', $barang->id) }}" method="POST">
@csrf
@method('PUT')

Nama Barang:
<input type="text" name="nama_barang" value="{{ $barang->nama_barang }}"><br>

Harga:
<input type="number" name="harga" value="{{ $barang->harga }}"><br>

<button type="submit">Update</button>
</form>