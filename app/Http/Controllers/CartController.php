<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Menampilkan halaman isi keranjang
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('buyer.cart.index', compact('cartItems'));
    }

    // 2. Menyimpan produk ke keranjang (Mendukung input Qty dari pop-up)
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $qtyRequested = $request->input('quantity', 1);

        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($existingCart) {
            $existingCart->increment('quantity', $qtyRequested);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $qtyRequested,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    // 3. Menambah quantity (+1) langsung di halaman keranjang
    public function updateQuantityPlus($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cart->increment('quantity');
        return redirect()->back();
    }

    // 4. Mengurangi quantity (-1) langsung di halaman keranjang
    public function updateQuantityMinus($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }
        
        return redirect()->back();
    }
}