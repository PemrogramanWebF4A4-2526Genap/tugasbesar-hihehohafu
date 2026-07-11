<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Menampilkan daftar produk milik penjual
    public function index()
    {
        $products = Product::where('seller_id', Auth::id())->get();
        return view('seller.products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        $categories = Category::all(); // Mengambil kategori yang Anda isi di phpMyAdmin tadi
        return view('seller.products.create', compact('categories'));
    }

    // Menyimpan produk baru ke database (Lengkap dengan Proteksi Validasi & Upload Gambar)
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Batasi tipe & ukuran file
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'seller_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}