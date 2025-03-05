<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $fillable = [
        'transaksi_id',
        'nama_barang',
        'harga_grosir',
        'jumlah',
        'total',
    ];
    protected $table = 'transaksi_items';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
