<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\CartController;   
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Mengarah ke HomeController (Halaman Utama Toko)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 1. RUTE KHUSUS PEMBELI (BUYER)
Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');
    
    // RUTE UNTUK MELIHAT RIWAYAT TRANSAKSI PEMBELI Pak
    Route::get('/buyer/transactions', [CheckoutController::class, 'transactionHistory'])->name('buyer.transactions');
});

// 2. RUTE KHUSUS PENJUAL (SELLER)
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
    
    // RUTE CRUD PRODUK PENJUAL
    Route::get('/seller/products', [ProductController::class, 'index'])->name('seller.products.index');
    Route::get('/seller/products/create', [ProductController::class, 'create'])->name('seller.products.create');
    Route::post('/seller/products', [ProductController::class, 'store'])->name('seller.products.store');
});

// 3. RUTE KHUSUS ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// 4. RUTE AKSES UNTUK FITUR KERANJANG & CHECKOUT
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    
    Route::post('/cart/update-plus/{id}', [CartController::class, 'updateQuantityPlus'])->name('cart.update.plus');
    Route::post('/cart/update-minus/{id}', [CartController::class, 'updateQuantityMinus'])->name('cart.update.minus');
    
    // Rute Proses Nota & Eksekusi Pembayaran (Sudah bersih dari duplikat)
    Route::get('/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Rute manajemen profil bawaan Laravel
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';