<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'pesanan_id',
        'metode',
        'status',
        'snap_token'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}