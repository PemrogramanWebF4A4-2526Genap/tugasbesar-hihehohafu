<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    // TAMBAHKAN FUNGSI JEMBATAN RELASI INI:
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}