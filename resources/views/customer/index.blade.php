@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Data Customer</h3>

    <!-- ACTION TOP -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="/customer/create-blob" class="btn btn-primary">Tambah (BLOB)</a>
            <a href="/customer/create-file" class="btn btn-success">Tambah (FILE)</a>
        </div>

        <!-- SEARCH -->
        <form method="GET" style="width:300px;">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Cari nama...">
        </form>
    </div>

    <!-- GRID -->
    <div class="row">
        @foreach($customers as $c)
        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100" style="border-radius:16px; overflow:hidden;">

                <!-- FOTO -->
                @if($c->foto_view)
                    <img src="{{ $c->foto_view }}" 
                         style="width:100%; height:200px; object-fit:cover;">
                @else
                    <div style="height:200px; display:flex; align-items:center; justify-content:center; background:#f5f5f5;">
                        No Image
                    </div>
                @endif

                <!-- BODY -->
                <div class="card-body">

                    <h5 class="card-title mb-1">{{ $c->nama }}</h5>

                    <p class="text-muted mb-2">
                        {{ $c->alamat }}
                    </p>

                    <small>
                        {{ $c->provinsi }}<br>
                        {{ $c->kota }}<br>
                        {{ $c->kecamatan }}<br>
                        {{ $c->kelurahan }}
                    </small>

                    <!-- BADGE -->
                    <div class="mt-2">
                        @if($c->foto_blob)
                            <span class="badge bg-primary">BLOB</span>
                        @elseif($c->foto_path)
                            <span class="badge bg-success">FILE</span>
                        @endif
                    </div>

                    <!-- ACTION -->
                    <div class="mt-3 d-flex gap-2">

                        <!-- DETAIL -->
                        <button class="btn btn-info btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailModal{{ $c->id }}">
                            Detail
                        </button>

                        <!-- EDIT -->
                        <a href="/customer/{{ $c->id }}/edit" 
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- DELETE -->
                        <form action="/customer/{{ $c->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus data ini?')">
                                Delete
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

        <!-- MODAL DETAIL -->
        <div class="modal fade" id="detailModal{{ $c->id }}">
          <div class="modal-dialog">
            <div class="modal-content p-3">

                @if($c->foto_view)
                <img src="{{ $c->foto_view }}" 
                     style="width:100%; height:200px; object-fit:cover;">
                @endif

                <h5 class="mt-3">{{ $c->nama }}</h5>

                <p>{{ $c->alamat }}</p>

                <small>
                    {{ $c->provinsi }}<br>
                    {{ $c->kota }}<br>
                    {{ $c->kecamatan }}<br>
                    {{ $c->kelurahan }}
                </small>

            </div>
          </div>
        </div>

        @endforeach
    </div>

</div>
@endsection