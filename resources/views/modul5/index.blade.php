@extends('layouts.app')

@section('title', 'Modul 5 -  Wilayah Administrasi')

@section('content')

<div class="container">
    <h4 class="mb-4">Modul 5 - Wilayah Administrasi Indonesia</h4>

    <!-- PROVINSI -->
    <div class="mb-3">
        <label>Provinsi</label>
        <select id="provinsi" class="form-control">
            <option value="">Pilih Provinsi</option>
        </select>
    </div>

    <!-- KOTA -->
    <div class="mb-3">
        <label>Kota / Kabupaten</label>
        <select id="kota" class="form-control">
            <option value="">Pilih Kota</option>
        </select>
    </div>

    <!-- KECAMATAN -->
    <div class="mb-3">
        <label>Kecamatan</label>
        <select id="kecamatan" class="form-control">
            <option value="">Pilih Kecamatan</option>
        </select>
    </div>

    <!-- KELURAHAN -->
    <div class="mb-3">
        <label>Kelurahan</label>
        <select id="kelurahan" class="form-control">
            <option value="">Pilih Kelurahan</option>
        </select>
    </div>

</div>

@endsection



@push('scripts')

<script>

$(document).ready(function(){

    // =============================
    // LOAD PROVINSI
    // =============================

    $.getJSON(
        "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
        function(data){

            $.each(data, function(i, prov){

                $("#provinsi").append(
                    `<option value="${prov.id}">${prov.name}</option>`
                );

            });

        }
    );


    // =============================
    // PROVINSI → KOTA
    // =============================

    $("#provinsi").change(function(){

        let id_provinsi = $(this).val()

        $("#kota").html('<option value="">Pilih Kota</option>')
        $("#kecamatan").html('<option value="">Pilih Kecamatan</option>')
        $("#kelurahan").html('<option value="">Pilih Kelurahan</option>')

        if(id_provinsi != ""){

            $.getJSON(
                `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id_provinsi}.json`,
                function(data){

                    $.each(data, function(i, kota){

                        $("#kota").append(
                            `<option value="${kota.id}">${kota.name}</option>`
                        )

                    })

                }
            )

        }

    })


    // =============================
    // KOTA → KECAMATAN
    // =============================

    $("#kota").change(function(){

        let id_kota = $(this).val()

        $("#kecamatan").html('<option value="">Pilih Kecamatan</option>')
        $("#kelurahan").html('<option value="">Pilih Kelurahan</option>')

        if(id_kota != ""){

            $.getJSON(
                `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id_kota}.json`,
                function(data){

                    $.each(data, function(i, kec){

                        $("#kecamatan").append(
                            `<option value="${kec.id}">${kec.name}</option>`
                        )

                    })

                }
            )

        }

    })


    // =============================
    // KECAMATAN → KELURAHAN
    // =============================

    $("#kecamatan").change(function(){

        let id_kecamatan = $(this).val()

        $("#kelurahan").html('<option value="">Pilih Kelurahan</option>')

        if(id_kecamatan != ""){

            $.getJSON(
                `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id_kecamatan}.json`,
                function(data){

                    $.each(data, function(i, kel){

                        $("#kelurahan").append(
                            `<option value="${kel.id}">${kel.name}</option>`
                        )

                    })

                }
            )

        }

    })


})

</script>

@endpush