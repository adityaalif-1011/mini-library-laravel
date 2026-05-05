<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'menus';
    protected $fillable = [
    'nama_menu',
    'harga'
];
}
