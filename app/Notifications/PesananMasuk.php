<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PesananMasuk extends Notification
{
    use Queueable;

    protected $transaction;

    // Menangkap data transaksi yang baru masuk pak
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    // Mengaktifkan penyimpanan notifikasi ke dalam database
    public function via($notifiable)
    {
        return ['database'];
    }

    // Struktur teks data notifikasi yang akan disimpan pak
    public function toArray($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'message' => 'Ada pesanan baru masuk dari ' . ($this->transaction->user->name ?? 'Pembeli') . ' senilai Rp ' . number_format($this->transaction->total_price, 0, ',', '.'),
        ];
    }
}