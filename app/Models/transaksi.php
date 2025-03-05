<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $fillable = [
        'total',
        'user',
        'toko'
    ];
    protected $table = 'transaksis';
    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }
}
