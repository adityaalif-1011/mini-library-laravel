<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>

@page {
    margin: 15mm 10mm;
}

body {
    margin: 0;
    padding: 0;
    position: relative;
}

.label {
    position: absolute;
    width: 38mm;
    height: 25mm;
    box-sizing: border-box;
    text-align: center;
    padding-top: 6mm;
    font-size: 11px;
}

</style>
</head>
<body>

@php
    $totalSlots = 40;
@endphp

@for($i = 0; $i < $totalSlots; $i++)

    @php
        $col = $i % 5;
        $row = floor($i / 5);

        $left = $col * 38;
        $top = $row * 25;
    @endphp

    @if(isset($labels[$i - $startIndex]) && $i >= $startIndex)
        <div class="label"
             style="left: {{ $left }}mm; top: {{ $top }}mm;">

            <strong>{{ $labels[$i - $startIndex]->nama_barang }}</strong><br>
            Rp {{ number_format($labels[$i - $startIndex]->harga,0,',','.') }}

        </div>
    @endif

@endfor

</body>
</html>