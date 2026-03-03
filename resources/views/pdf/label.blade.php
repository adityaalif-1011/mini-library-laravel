<!DOCTYPE html>
<html>
<head>
<style>
@page {
    margin: 0;
}

body {
    margin: 0;
    padding: 0;
}

.page {
    width: 210mm;
    height: 296mm;
    position: relative;
}

.label {
    width: 38mm;
    height: 25mm;
    position: absolute;
    border: 1px solid black;
}

.label-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    text-align: center;
    font-size: 10px;
}
</style>
</head>
<body>

<div class="page">

@php
$columns = 5;
$labelWidth = 38;
$labelHeight = 25;
@endphp

@foreach($labels as $index => $barang)

@php
$position = $startIndex + $index;
$row = floor($position / $columns);
$col = $position % $columns;

$top = $row * $labelHeight;
$left = $col * $labelWidth;
@endphp

<div class="label"
     style="top: {{ $top }}mm; left: {{ $left }}mm;">

    <div class="label-content">
        <strong>{{ $barang->nama_barang }}</strong><br>
        Rp {{ number_format($barang->harga,0,',','.') }}
    </div>

</div>

@endforeach

</div>

</body>
</html>