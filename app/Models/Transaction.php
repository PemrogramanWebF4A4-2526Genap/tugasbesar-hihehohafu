<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    /**
     * FUNGSI RELASI FINAL: Menghubungkan nota transaksi ke data akun pengguna pak
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}