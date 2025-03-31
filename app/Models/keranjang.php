<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs';

    protected $fillable = [
        'user_id',
        'barang_id',
        'nama',
        'harga',
        'harga_grosir',
        'image',
        'quantity'
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related product
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
