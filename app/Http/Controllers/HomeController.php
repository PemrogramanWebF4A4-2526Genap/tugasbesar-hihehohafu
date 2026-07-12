<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama marketplace dengan fitur filter pencarian pembeli pak
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Jika pembeli mengetik sesuatu di searchbar depan
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil data produk terbaru pak
        $products = $query->latest()->get();

        // Silakan sesuaikan nama view di bawah ini dengan nama file blade utama abang (welcome atau home)
        return view('welcome', compact('products'));
    }
}