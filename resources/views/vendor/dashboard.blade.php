@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Alert Success -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Alert Error -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">🏪 Dashboard Vendor</h4>
                </div>
                <div class="card-body">
                    <!-- Informasi Vendor -->
                    <div class="alert alert-info">
                        <strong>Selamat datang, {{ Auth::user()->name }}</strong><br>
                        Email: {{ Auth::user()->email }}<br>
                        Role: <strong class="text-success">VENDOR</strong>
                        @if($vendor)
                            <br>Nama Vendor: <strong>{{ $vendor->nama_vendor }}</strong>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <!-- Form Tambah Menu -->
                    <h5>➕ Tambah Menu Baru</h5>
                    <form action="{{ route('vendor.menu.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="nama_menu" class="form-control" placeholder="Nama Menu (contoh: Sate Ayam)" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="harga" class="form-control" placeholder="Harga (contoh: 15000)" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success w-100">Tambah Menu</button>
                            </div>
                        </div>
                    </form>
                    
                    <hr>
                    
                    <!-- Daftar Menu -->
                    <h5>📋 Daftar Menu Saya</h5>
                    
                    @if($menus->count() > 0)
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menus as $key => $menu)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $menu->nama_menu }}</td>
                                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('vendor.menu.delete', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin hapus menu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-secondary">
                            Belum ada menu. Silakan tambah menu di atas.
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection