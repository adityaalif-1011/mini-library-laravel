@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">Data Barang</h3>
</div>

<div class="card">
    <div class="card-body">

        <div class="mb-3">
            <a href="{{ route('barangs.create') }}" class="btn btn-primary">
                + Tambah Barang
            </a>
        </div>

        <form action="{{ route('barangs.cetak') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Posisi Baris (1-5)</label>
                <input type="number" name="x" min="1" max="5" 
                       class="form-control" required>
            </div>

            <div class="col-md-3">
                <label>Posisi Kolom (1-8)</label>
                <input type="number" name="y" min="1" max="8" 
                       class="form-control" required>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-success">
                    Cetak Label
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">Pilih</th>
                        <th>ID</th>
                        <th>ID Barang</th>
                        <th>Nama</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $b)
                    <tr>
                        <td>
                            <input type="checkbox" 
                                   name="selected[]" 
                                   value="{{ $b->id }}">
                        </td>
                        <td>{{ $b->id }}</td>
                        <td>{{ $b->id_barang }}</td>
                        <td>{{ $b->nama_barang }}</td>
                        <td>
                            Rp {{ number_format($b->harga,0,',','.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        </form>

    </div>
</div>

@endsection