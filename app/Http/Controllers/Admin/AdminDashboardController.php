<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Data untuk Laporan & Analitik
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $revenue = Transaction::where('status', 'success')->sum('total_price');

        // Data untuk Manajemen & Monitoring pak
        $allUsers = User::latest()->get();
        $allCategories = Category::latest()->get();
        $allTransactions = Transaction::with('user')->latest()->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalProducts', 'totalTransactions', 'revenue',
            'allUsers', 'allCategories', 'allTransactions'
        ));
    }
}