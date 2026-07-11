<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Konfirmasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-200">
                <h3 class="text-xl font-black text-gray-950 mb-6 flex items-center gap-2">💳 Detail Tagihan</h3>

                <div class="border-b border-gray-200 pb-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700 font-bold text-sm">Nama Produk:</span>
                        <span class="text-gray-900 font-extrabold text-sm">{{ $product->name }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700 font-bold text-sm">Harga Satuan:</span>
                        <span class="text-gray-900 font-extrabold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-bold text-sm">Jumlah Barang:</span>
                        <span class="text-gray-900 font-extrabold text-sm">{{ $quantity }} Pcs</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('checkout.process') }}">
                    @csrf
                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-800 font-black text-base">Total Bayar:</span>
                        <span class="text-2xl font-black text-orange-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <button type="submit" class="w-full text-center bg-orange-500 hover:bg-orange-600 text-black
                         font-black py-3 px-6 rounded-xl shadow-md transition-all cursor-pointer">
                            Konfirmasi & Bayar Sekarang 🚀
                        </button>
                        <a href="{{ route('cart.index') }}" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl text-sm transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>