<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\PesananMasuk; // SUDAH DI-IMPORT PAK
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        $sellerId = $product->user_id ?? $product->seller_id; 

        // VALIDASI: Cek apakah uang saldo dummy milik pembeli cukup atau kurang
        if ($buyer->balance < $request->total_price) {
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
        $transaction = Transaction::create([
            'user_id' => $buyer->id,
            'total_price' => $request->total_price,
            'status' => 'success',
        ]);

        // 4. KIRIM NOTIFIKASI KE ADMIN SEBAGAI PENJUAL GLOBAL PAK (DI SINI TEMPATNYA)
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new PesananMasuk($transaction));
        }

        // 5. BERSIHKAN BARANG DARI KERANJANG BELANJA
        Cart::where('user_id', $buyer->id)->delete();

        return redirect()->route('dashboard')->with('success', 'Pembayaran Berhasil! Saldo Anda terpotong dan uang otomatis diteruskan ke dompet penjual.');
    }

    /**
     * Menampilkan daftar riwayat transaksi milik pembeli yang sedang login
     */
    public function transactionHistory()
    {
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();
        return view('buyer.transaction.index', compact('transactions'));
    } 

    /**
     * FUNGSI UTAS FINAL: Menyimpan ulasan kalimat pembeli ke kolom comment yang sudah dibuat pak
     */
    public function storeReview(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required',
            'comment' => 'required|string|max:255',
        ]);

        // Menyimpan data ulasan per baris transaksi menggunakan query builder murni
        $exists = DB::table('reviews')->where('id', $request->transaction_id)->exists();

        if ($exists) {
            DB::table('reviews')->where('id', $request->transaction_id)->update([
                'comment' => $request->comment,
                'updated_at' => now()
            ]);
        } else {
            DB::table('reviews')->insert([
                'id' => $request->transaction_id,
                'comment' => $request->comment,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Ulasan kalimat Anda berhasil dikirim dan diteruskan ke Penjual!');
    }
}