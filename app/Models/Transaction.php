<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // SUDAH DI-IMPORT PAK

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    /**
     * Relasi ke model User (Pemilik Transaksi) pak
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}