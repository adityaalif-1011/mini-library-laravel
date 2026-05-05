@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🍽️ Daftar Menu</h4>
                    <p class="mb-0 text-white-50">Kelola menu makanan/minuman anda</p>
                </div>
                <div class="card-body">
                    
                    <!-- Form Tambah Menu -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">➕ Tambah Menu Baru</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vendor.menu.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="nama_menu" class="form-control" placeholder="Nama Menu" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="harga" class="form-control" placeholder="Harga" required>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-success w-100">Tambah Menu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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