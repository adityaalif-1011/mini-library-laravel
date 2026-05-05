<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    'nama',
    'alamat',
    'provinsi',
    'kota',
    'kecamatan',
    'kelurahan',
    'foto_blob',
    'foto_path'
];
}
