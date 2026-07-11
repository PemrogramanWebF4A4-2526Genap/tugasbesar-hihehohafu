<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Mengizinkan kolom-kolom ini untuk diisi data
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Jembatan relasi untuk mengambil data produk di halaman keranjang
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}