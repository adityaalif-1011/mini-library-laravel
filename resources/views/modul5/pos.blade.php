@extends('layouts.app')

@section('title', 'POS Kasir')

@section('content')

<div class="container">

<h4 class="mb-4">Point Of Sales (POS)</h4>

<div class="mb-3">
    <label>Kode Barang</label>
    <input type="text" id="kode_barang" class="form-control">
</div>

<div class="mb-3">
    <label>Nama Barang</label>
    <input type="text" id="nama_barang" class="form-control" readonly>
</div>

<div class="mb-3">
    <label>Harga Barang</label>
    <input type="number" id="harga_barang" class="form-control" readonly>
</div>

<div class="mb-3">
    <label>Jumlah</label>
    <input type="number" id="jumlah" class="form-control" value="1">
</div>

<button id="btnTambah" class="btn btn-success mb-3" disabled>Tambahkan</button>

<table class="table table-bordered" id="tablePos">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<h5>Total: Rp <span id="total">0</span></h5>

<button id="btnBayar" class="btn btn-primary">Bayar</button>

</div>

@endsection


@push('scripts')

<!-- MIDTRANS SNAP -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="Mid-client-Zun4_lWemKnTEQiF"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
})

let total = 0

// =====================
// ENTER → CARI BARANG
// =====================
$("#kode_barang").keypress(function(e){
    if(e.which == 13){
        let kode = $(this).val()

        axios.get('/fake-api/barang/' + kode)
        .then(function(response){
            let data = response.data
            $("#nama_barang").val(data.nama)
            $("#harga_barang").val(data.harga)
            $("#jumlah").val(1)
            $("#btnTambah").prop("disabled", false)
        })
        .catch(function(){
            Swal.fire("Error", "Barang tidak ditemukan", "error")
            $("#btnTambah").prop("disabled", true)
            $("#nama_barang").val("")
            $("#harga_barang").val("")
        })
    }
})

// =====================
// TAMBAH KE TABEL
// =====================
$("#btnTambah").click(function(){

    let kode = $("#kode_barang").val()
    let nama = $("#nama_barang").val()
    let harga = parseInt($("#harga_barang").val())
    let jumlah = parseInt($("#jumlah").val())

    let subtotal = harga * jumlah

    let existing = $(`#tablePos tbody tr[data-kode="${kode}"]`)

    if(existing.length > 0){
        let oldJumlah = parseInt(existing.find(".jumlah").val())
        let newJumlah = oldJumlah + jumlah

        existing.find(".jumlah").val(newJumlah)
        existing.find(".subtotal").text(newJumlah * harga)
    } else {
        $("#tablePos tbody").append(`
            <tr data-kode="${kode}">
                <td>${kode}</td>
                <td>${nama}</td>
                <td>${harga}</td>
                <td><input type="number" class="jumlah form-control" value="${jumlah}"></td>
                <td class="subtotal">${subtotal}</td>
                <td><button class="btn btn-danger btnHapus">X</button></td>
            </tr>
        `)
    }

    hitungTotal()
    resetForm()
})

// =====================
// UPDATE JUMLAH
// =====================
$(document).on("input", ".jumlah", function(){
    let row = $(this).closest("tr")
    let harga = parseInt(row.find("td:eq(2)").text())
    let jumlah = parseInt($(this).val())
    if(jumlah <= 0) jumlah = 1
    row.find(".subtotal").text(harga * jumlah)
    hitungTotal()
})

// =====================
// HAPUS BARANG
// =====================
$(document).on("click", ".btnHapus", function(){
    $(this).closest("tr").remove()
    hitungTotal()
})

// =====================
// HITUNG TOTAL
// =====================
function hitungTotal(){
    total = 0
    $("#tablePos tbody tr").each(function(){
        total += parseInt($(this).find(".subtotal").text())
    })
    $("#total").text(total)
}

// =====================
// RESET FORM
// =====================
function resetForm(){
    $("#kode_barang").val("")
    $("#nama_barang").val("")
    $("#harga_barang").val("")
    $("#jumlah").val(1)
    $("#btnTambah").prop("disabled", true)
}

// =====================
// BAYAR → MIDTRANS
// =====================
$("#btnBayar").click(function(){

    if(total == 0){
        Swal.fire("Warning", "Belum ada transaksi", "warning")
        return
    }

    let items = []

    $("#tablePos tbody tr").each(function(){
        items.push({
            id: $(this).data("kode"),
            qty: parseInt($(this).find(".jumlah").val()),
            harga: parseInt($(this).find("td:eq(2)").text())
        })
    })

    $.post('/order', {
        total: total,
        items: items
    }, function(res){

        let id = res.pesanan_id

        Swal.fire({
            title: "Konfirmasi Pembayaran",
            html: `<h3>Total: Rp ${total}</h3>`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Bayar"
        }).then((result) => {

            if(result.isConfirmed){

                // ambil snap token
                $.get('/snap-token/' + id, function(token){

                    snap.pay(token, {

                        onSuccess: function(result){
                            Swal.fire("Sukses", "Pembayaran berhasil", "success")

                            $.post('/payment/' + id, function(){
        window.location.href = '/payment/success/' + id
    })
                        },

                        onPending: function(){
                            Swal.fire("Pending", "Menunggu pembayaran", "info")
                        },

                        onError: function(err){
                            console.log(err)
                            Swal.fire("Error", "Pembayaran gagal", "error")
                        }

                    })

                })

            }

        })

    })

})

</script>

@endpush