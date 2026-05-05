<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    
    protected $fillable = [
        'nama_customer',
        'total',
        'status'
    ];

    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}