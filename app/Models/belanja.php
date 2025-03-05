<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class belanja extends Model
{
    protected $fillable = [
        'nama_barang',
        'jumlah_pesanan',
        'satuan',
        'stok',
        'pemasok',
        'gambar'
    ];
}
