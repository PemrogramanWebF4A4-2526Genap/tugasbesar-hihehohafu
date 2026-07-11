<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman konfirmasi pembayaran
     */
    public function directCheckout(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Mencari data quantity asli dari keranjang belanja milik user
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        // Jika ada di keranjang pakai quantity tersebut, jika tidak (beli langsung) default ke 1
        $quantity = $cartItem ? $cartItem->quantity : 1;
        
        // Menghitung total harga tagihan
        $totalPrice = $product->price * $quantity;

        return view('buyer.checkout.index', compact('product', 'quantity', 'totalPrice'));
    }

    /**
     * Memproses pemotongan saldo pembeli dan penambahan saldo penjual
     */
    public function process(Request $request)
    {
        $buyer = Auth::user();
        $product = Product::findOrFail($request->product_id);
        
        // SISTEM DETEKSI OTOMATIS PEMILIK PRODUK Pak
        // Mengecek apakah tabel products Anda menggunakan kolom 'user_id' atau 'seller_id'
        $sellerId = $product->user_id ?? $product->seller_id; 

        // VALIDASI: Cek apakah uang saldo dummy milik pembeli cukup atau kurang
        if ($buyer->balance < $request->total_price) {
            // Kondisi JELEK: Saldo kurang, transaksi langsung digagalkan
            return redirect()->route('cart.index')->with('error', 'Transaksi Gagal! Saldo dummy Anda tidak mencukupi untuk melakukan pembayaran.');
        }

        // 1. EKSEKUSI POTONG SALDO AKUN PEMBELI
        $buyer->decrement('balance', $request->total_price);

        // 2. EKSEKUSI TAMBAH SALDO AKUN PENJUAL (UANG MASUK TOKO)
        if ($sellerId) {
            $seller = User::find($sellerId);
            if ($seller) {
                $seller->increment('balance', $request->total_price);
            }
        }

        // 3. CATAT NOTA RIWAYAT TRANSAKSI KE DATABASE
        Transaction::create([
            'user_id' => $buyer->id,
            'total_price' => $request->total_price,
            'status' => 'success',
        ]);

        // 4. BERSIHKAN BARANG DARI KERANJANG BELANJA
        Cart::where('user_id', $buyer->id)->delete();

        // Kembali ke dashboard dengan membawa pesan sukses berwujud banner hijau
        return redirect()->route('dashboard')->with('success', 'Pembayaran Berhasil! Saldo dummy Anda terpotong dan uang otomatis diteruskan ke dompet penjual.');
    }

    /**
     * Menampilkan daftar riwayat transaksi milik pembeli yang sedang login
     * (DI SINI TEMPATNYA PAK)
     */
    public function transactionHistory()
    {
        // Mengambil semua data transaksi milik user ini, diurutkan dari yang paling baru
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();

        return view('buyer.transaction.index', compact('transactions'));
    } 
} // <-- Ini kurung kurawal penutup akhir dari file controller Anda