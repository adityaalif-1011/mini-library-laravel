@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Data Buku</h3>
</div>

<div class="card">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">
            Tambah Buku
        </a>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->kategori->nama_kategori }}</td>
                            <td>{{ $b->kode }}</td>
                            <td>{{ $b->judul }}</td>
                            <td>{{ $b->pengarang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
