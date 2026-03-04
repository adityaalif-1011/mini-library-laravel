@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Barang</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('barangs.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">
                Simpan
            </button>

            <a href="{{ route('barangs.index') }}" class="btn btn-secondary mt-3">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection