<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request)
{
    $query = Customer::query();

    if ($request->search) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    $customers = $query->latest()->get();

    foreach ($customers as $c) {
        if ($c->foto_blob) {
            $c->foto_view = $c->foto_blob;
        } elseif ($c->foto_path) {
            $c->foto_view = url('storage/customer/' . basename($c->foto_path));
        } else {
            $c->foto_view = null;
        }
    }

    return view('customer.index', compact('customers'));
}

    public function createBlob()
    {
        return view('customer.create_blob');
    }

    public function createFile()
    {
        return view('customer.create_file');
    }

    // 🔥 SIMPAN BLOB (BASE64)
    public function storeBlob(Request $request)
    {
        if (!$request->foto) {
            return "Foto belum diambil";
        }

        Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'foto_blob' => $request->foto // ✅ langsung simpan base64
        ]);

        return redirect('/customer');
    }

    // 🔥 SIMPAN FILE
    public function storeFile(Request $request)
{
    // validasi sederhana
    if (!$request->foto) {
        return "Foto belum diambil";
    }

    // ambil base64 dari input
    $image = $request->foto;

    // bersihkan prefix
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    // generate nama file unik
    $fileName = time() . '.png';

    // simpan ke storage/app/public/customer
    Storage::disk('public')->put('customer/' . $fileName, base64_decode($image));

    // simpan ke database
    Customer::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'provinsi' => $request->provinsi,
        'kota' => $request->kota,
        'kecamatan' => $request->kecamatan,
        'kelurahan' => $request->kelurahan,
        'foto_path' => 'storage/customer/' . $fileName
    ]);

    return redirect('/customer');
}

public function destroy($id)
{
    $customer = Customer::findOrFail($id);

    // hapus file kalau ada
    if ($customer->foto_path) {
        $file = str_replace('storage/', '', $customer->foto_path);
        Storage::disk('public')->delete($file);
    }

    $customer->delete();

    return redirect('/customer')->with('success', 'Data dihapus');
}

public function edit($id)
{
    $customer = Customer::findOrFail($id);
    return view('customer.edit', compact('customer'));
}

public function update(Request $request, $id)
{
    $customer = Customer::findOrFail($id);

    $customer->update([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'provinsi' => $request->provinsi,
        'kota' => $request->kota,
        'kecamatan' => $request->kecamatan,
        'kelurahan' => $request->kelurahan,
    ]);

    return redirect('/customer')->with('success', 'Data diupdate');
}


}