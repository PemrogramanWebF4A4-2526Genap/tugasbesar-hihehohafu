<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembeli (Buyer)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl font-bold text-sm border border-green-200">
                    🎉 {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl mb-6 border border-gray-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="font-black text-lg text-gray-900">Selamat datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-500 text-sm mt-0.5">Pantau uang digital dan kelola belanjaan Anda di sini.</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-3 text-left md:text-right w-full md:w-auto shrink-0">
                    <span class="text-xs font-bold text-green-700 uppercase tracking-wider block">💰 Saldo Belanja:</span>
                    <span class="text-xl font-black text-green-600 block mt-0.5">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">🛒 Keranjang Belanja Anda</h3>
                    <p class="text-gray-500 text-sm mb-4">Lihat produk-produk yang sudah Anda pilih dan siap untuk dibayar.</p>
                    <a href="{{ route('cart.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-5 rounded-xl shadow-xs transition text-sm cursor-pointer">
                        Buka Keranjang &rarr;
                    </a>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">📦 Riwayat Transaksi</h3>
                    <p class="text-gray-500 text-sm mb-4">Pantau status pengiriman barang dan daftar belanjaan yang sudah selesai.</p>
                    
                    <a href="{{ route('buyer.transactions') }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded-xl shadow-xs transition text-sm cursor-pointer">
                        Lihat Riwayat &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>