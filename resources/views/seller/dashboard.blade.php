<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Penjual (Seller)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl flex justify-between items-center bg-gradient-to-r from-blue-50 to-white">
                <div>
                    <span class="text-xs font-bold text-blue-800 uppercase tracking-wider block">💰 Total Saldo Toko Anda</span>
                    <h3 class="text-3xl font-black text-blue-600 mt-1">
                        Rp {{ number_format($seller->balance, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="text-sm bg-blue-100 text-blue-800 px-4 py-2 rounded-xl font-bold">
                    Toko Aktif ✔
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">📦 Produk Yang Saya Jual</h3>
                    <p class="text-gray-500 text-sm mb-4">Lihat daftar barang dagangan Anda yang sedang aktif dipajang di toko.</p>
                    <a href="{{ route('seller.products.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-xs transition text-sm cursor-pointer">
                        Lihat Semua Produk &rarr;
                    </a>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">➕ Tambah Produk Jualan</h3>
                    <p class="text-gray-500 text-sm mb-4">Masukkan produk baru, set harga, dan stok barang untuk mulai berjualan.</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-xl shadow-xs transition text-sm cursor-pointer">
                        Tambah Produk Baru &rarr;
                    </a>
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <h3 class="text-lg font-black text-gray-950 mb-4">📥 Inbox Pesanan Baru (Resi Masuk)</h3>
                
                @if($incomingOrders->isEmpty())
                    <p class="text-gray-500 text-sm italic">Belum ada pesanan atau resi masuk dari pembeli.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($incomingOrders as $order)
                            <div class="border-2 border-dashed border-gray-200 p-4 rounded-xl bg-gray-50 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-black text-gray-900">#RES-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-sm bg-green-100 text-green-800">PAID</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Waktu Masuk: {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    
                                    <div class="border-t border-gray-200 my-2 pt-2 flex justify-between items-center">
                                        <span class="text-xs text-gray-600">Dana Diterima:</span>
                                        <span class="text-sm font-black text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="mt-2 pt-2 border-t border-gray-200">
                                        @php
                                            $buyerReview = \App\Models\Review::find($order->id);
                                        @endphp
                                        @if($buyerReview)
                                            @php
                                                $sellerReviewText = collect($buyerReview->getAttributes())->except(['id', 'created_at', 'updated_at', 'transaction_id', 'user_id', 'product_id'])->first();
                                            @endphp
                                            @if($sellerReviewText)
                                                <div class="bg-blue-50 border border-blue-100 p-2 rounded-lg text-xs">
                                                    <span class="font-bold text-blue-700 block">💬 Ulasan Pembeli:</span>
                                                    <p class="text-gray-600 italic mt-0.5">"{{ $sellerReviewText }}"</p>
                                                </div>
                                            @else
                                                <span class="text-[11px] text-gray-400 italic block">🔒 Belum ada ulasan kalimat untuk resi ini</span>
                                            @endif
                                        @else
                                            <span class="text-[11px] text-gray-400 italic block">🔒 Belum ada ulasan kalimat untuk resi ini</span>
                                        @endif
                                    </div>
                                </div>

                                <button class="w-full mt-4 bg-blue-600 text-white text-xs font-bold py-1.5 rounded-lg cursor-pointer hover:bg-blue-700 transition">
                                    Konfirmasi Pengiriman
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>