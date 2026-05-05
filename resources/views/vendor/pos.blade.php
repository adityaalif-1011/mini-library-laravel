@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🛒 Pemesanan Customer</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-7">
                            <!-- Pilih Vendor -->
                            <div class="card mb-3">
                                <div class="card-header">Pilih Vendor</div>
                                <div class="card-body">
                                    <select id="vendor_id" class="form-select">
                                        <option value="">-- Pilih Vendor --</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->nama_vendor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Daftar Menu -->
                            <div class="card">
                                <div class="card-header">Daftar Menu</div>
                                <div class="card-body">
                                    <div id="menuList"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">Keranjang</div>
                                <div class="card-body">
                                    <div id="cartList"></div>
                                    <hr>
                                    <h5>Total: Rp <span id="total">0</span></h5>
                                    <button id="btnBayar" class="btn btn-success w-100" disabled>Bayar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-Zun4_lWemKnTEQiF"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let cart = [];
let total = 0;

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Pilih Vendor
$('#vendor_id').change(function() {
    let vendorId = $(this).val();
    if(vendorId) {
        $.get('/api/menus/' + vendorId, function(menus) {
            let html = '<div class="list-group">';
            menus.forEach(menu => {
                html += `
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${menu.nama_menu}</strong><br>
                                <small>Rp ${formatNumber(menu.harga)}</small>
                            </div>
                            <div>
                                <input type="number" id="qty_${menu.id}" class="form-control form-control-sm" style="width: 70px; display: inline-block;" value="1" min="1">
                                <button class="btn btn-sm btn-primary" onclick="addToCart(${menu.id}, '${menu.nama_menu}', ${menu.harga})">Tambah</button>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            $('#menuList').html(html);
        });
    }
});

// Tambah ke Keranjang
function addToCart(id, name, price) {
    let qty = parseInt($('#qty_' + id).val());
    let existing = cart.find(item => item.id == id);
    if(existing) {
        existing.qty += qty;
        existing.subtotal = existing.price * existing.qty;
    } else {
        cart.push({ id: id, name: name, price: price, qty: qty, subtotal: price * qty });
    }
    renderCart();
}

// Tampilkan Keranjang
function renderCart() {
    let html = '';
    total = 0;
    if(cart.length === 0) {
        html = '<p class="text-center text-muted">Keranjang kosong</p>';
        $('#btnBayar').prop('disabled', true);
    } else {
        cart.forEach((item, index) => {
            total += item.subtotal;
            html += `
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>${item.name}</strong><br>
                            <small>${formatNumber(item.price)} x ${item.qty}</small>
                        </div>
                        <div>
                            Rp ${formatNumber(item.subtotal)}
                            <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">X</button>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#btnBayar').prop('disabled', false);
    }
    $('#cartList').html(html);
    $('#total').text(formatNumber(total));
}

// Hapus Item
function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

// Format Rupiah
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// // Proses Bayar
// $('#btnBayar').click(function() {
//     if(cart.length === 0) {
//         Swal.fire('Error', 'Keranjang kosong', 'error');
//         return;
//     }
    
//     let items = cart.map(item => ({
//         menu_id: item.id,
//         qty: item.qty,
//         harga: item.price
//     }));
    
//     Swal.fire({
//         title: 'Konfirmasi',
//         html: `Total: <strong>Rp ${formatNumber(total)}</strong>`,
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonText: 'Ya, Bayar'
//     }).then((result) => {
//         if(result.isConfirmed) {
//             // Buat pesanan
//             $.post('/kantin/order', { items: items, total: total })
//                 .done(function(res) {
//                     // Ambil snap token
//                     $.get('/kantin/snap-token/' + res.pesanan_id)
//                         .done(function(token) {
//                             snap.pay(token, {
//                                 onSuccess: function() {
//                                     $.post('/kantin/payment/' + res.pesanan_id)
//                                         .done(function() {
//                                             Swal.fire('Sukses!', 'Pembayaran berhasil', 'success')
//                                                 .then(() => window.location.href = '/kantin/success/' + res.pesanan_id);
//                                         });
//                                 },
//                                 onPending: () => Swal.fire('Pending', 'Menunggu pembayaran', 'info'),
//                                 onError: () => Swal.fire('Error', 'Pembayaran gagal', 'error')
//                             });
//                         });
//                 })
//                 .fail(() => Swal.fire('Error', 'Gagal membuat pesanan', 'error'));
//         }
//     });
// });
// Proses Bayar (Versi dengan fetch + CSRF manual)
$('#btnBayar').click(function() {
    if(cart.length === 0) {
        Swal.fire('Error', 'Keranjang kosong', 'error');
        return;
    }
    
    let items = cart.map(item => ({
        menu_id: item.id,
        qty: item.qty,
        harga: item.price
    }));
    
    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        html: `Total: <strong>Rp ${formatNumber(total)}</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Bayar',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed) {
            // Tampilkan loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            
            $.ajax({
                url: '/kantin/order',
                method: 'POST',
                data: JSON.stringify({ items: items, total: total }),
                contentType: 'application/json',
                success: function(res) {
                    $.ajax({
                        url: '/kantin/snap-token/' + res.pesanan_id,
                        method: 'GET',
                        success: function(token) {
                            Swal.close();
                            // Popup Midtrans langsung muncul
                            snap.pay(token, {
                                onSuccess: function() {
                                    $.ajax({
                                        url: '/kantin/payment/' + res.pesanan_id,
                                        method: 'POST',
                                        success: function() {
                                            Swal.fire('Sukses!', 'Pembayaran berhasil', 'success')
                                                .then(() => {
                                                    window.location.href = '/kantin/success/' + res.pesanan_id;
                                                });
                                        }
                                    });
                                },
                                onPending: function() {
                                    Swal.fire('Pending', 'Menunggu pembayaran', 'info');
                                },
                                onError: function(err) {
                                    console.log(err);
                                    Swal.fire('Error', 'Pembayaran gagal', 'error');
                                }
                            });
                        },
                        error: function(err) {
                            Swal.close();
                            Swal.fire('Error', 'Gagal mendapatkan token', 'error');
                        }
                    });
                },
                error: function(err) {
                    Swal.close();
                    Swal.fire('Error', 'Gagal membuat pesanan', 'error');
                }
            });
        }
    });
});
</script>
@endsection