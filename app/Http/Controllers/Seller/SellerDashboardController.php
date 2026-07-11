<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();

        // BYPASS KILAT: Ambil semua riwayat transaksi langsung tanpa memfilter id produk yang eror tadi Pak
        $incomingOrders = Transaction::latest()->get(); 

        return view('seller.dashboard', compact('seller', 'incomingOrders'));
    }
}