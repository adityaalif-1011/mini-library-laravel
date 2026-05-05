@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">📋 Pesanan Lunas</h4>
                    <p class="mb-0 text-white-50">Pesanan dari customer yang sudah dibayar</p>
                </div>
                <div class="card-body">
                    
                    @if($pesananLunas->count() > 0)
                        @foreach($pesananLunas as $pesanan)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between">
                                        <strong>🧾 Pesanan #{{ $pesanan->id }}</strong>
                                        <span class="badge bg-success">LUNAS</span>
                                    </div>
                                    <small>Customer: {{ $pesanan->nama_customer }}</small><br>
                                    <small>Tanggal: {{ $pesanan->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total = 0; @endphp
                                            @foreach($pesanan->details as $detail)
                                                @if($detail->menu_id && $detail->menu)
                                                    @php $total += $detail->subtotal; @endphp
                                                    <tr>
                                                        <td>{{ $detail->menu->nama_menu }}</td>
                                                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                        <td>{{ $detail->qty }}</td>
                                                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr class="table-active">
                                                <td colspan="3"><strong>Total</strong></td>
                                                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-secondary text-center">
                            <i class="mdi mdi-receipt"></i> Belum ada pesanan lunas dari customer.
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection