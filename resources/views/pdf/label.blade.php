@foreach ($labels as $item)

<div style="
    border:1px solid black;
    width:200px;
    margin-bottom:10px;
    text-align:center;
    padding:5px;
">

    <!-- NAMA MENU -->
    <div style="font-size:10px; font-weight:bold;">
        {{ $item->nama_menu }}
    </div>

    <!-- BARCODE -->
    <div>
        <img src="data:image/png;base64,{{ $item->barcode }}" 
             style="width:100%; height:40px;">
    </div>

    <!-- ID -->
    <div style="font-size:9px;">
        ID: {{ $item->id }}
    </div>

    <!-- HARGA -->
    <div style="font-size:12px; font-weight:bold;">
        Rp {{ number_format($item->harga,0,',','.') }}
    </div>

</div>

@endforeach