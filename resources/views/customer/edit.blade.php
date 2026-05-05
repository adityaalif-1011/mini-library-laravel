@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Edit Customer</h3>

    <form method="POST" action="/customer/{{ $customer->id }}">
        @csrf
        @method('PUT')

        <input type="text" name="nama" value="{{ $customer->nama }}" class="form-control my-2">
        <input type="text" name="alamat" value="{{ $customer->alamat }}" class="form-control my-2">
        <input type="text" name="provinsi" value="{{ $customer->provinsi }}" class="form-control my-2">
        <input type="text" name="kota" value="{{ $customer->kota }}" class="form-control my-2">
        <input type="text" name="kecamatan" value="{{ $customer->kecamatan }}" class="form-control my-2">
        <input type="text" name="kelurahan" value="{{ $customer->kelurahan }}" class="form-control my-2">

        <button class="btn btn-success">Update</button>
    </form>

</div>
@endsection