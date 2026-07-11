<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua data produk beserta kategorinya dari database
        $products = Product::with('category')->get();
        
        // Melempar data produk ke halaman welcome.blade.php
        return view('welcome', compact('products'));
    }
}