<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Keranjang Belanjaan Anda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-200">
                <h3 class="text-xl font-black text-gray-950 mb-6 flex items-center gap-2">🛒 Daftar Belanja</h3>

                @if($cartItems->isEmpty())
                    <div class="text-center py-12 text-gray-700">
                        <p class="text-lg font-bold mb-4">Keranjang belanja Anda masih kosong melongpong.</p>
                        <a href="{{ url('/') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-sm">
                            Yuk, Cari Produk!
                        </a>
                    </div>
                @else
                    <div class="block w-full space-y-6">
                        @php $grandTotal = 0; @endphp
                        @foreach($cartItems as $item)
                            @php 
                                $subTotal = ($item->product->price ?? 0) * $item->quantity; 
                                $grandTotal += $subTotal;
                            @endphp
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-gray-200 pb-6 gap-4">
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden border border-gray-300 flex items-center justify-center p-1 shrink-0">
                                        @if($item->product->image ?? false)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="max-w-full max-h-full object-contain">
                                        @else
                                            <div class="text-[10px] text-gray-500">No Image</div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-gray-950 text-base">{{ $item->product->name ?? 'Produk Tidak Diketahui' }}</h4>
                                        <p class="text-sm text-gray-700 mt-1 font-medium">Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</p>
                                        
                                        <div class="flex items-center gap-2 mt-2">
                                            <form method="POST" action="{{ route('cart.update.minus', $item->id) }}">
                                                @csrf
                                                <button type="submit" class="w-7 h-7 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-bold text-sm flex items-center justify-center transition">-</button>
                                            </form>
                                            <span class="text-gray-900 font-bold px-2 text-sm">{{ $item->quantity }}</span>
                                            <form method="POST" action="{{ route('cart.update.plus', $item->id) }}">
                                                @csrf
                                                <button type="submit" class="w-7 h-7 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-bold text-sm flex items-center justify-center transition">+</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right w-full sm:w-auto shrink-0 border-t sm:border-t-0 pt-2 sm:pt-0">
                                    <p class="font-black text-green-700 text-lg">Rp {{ number_format($subTotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-6 border-t border-gray-300 w-full">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-800 font-extrabold text-base">Total Harga ({{ $cartItems->sum('quantity') }} Barang):</span>
                                <span class="text-2xl font-black text-orange-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <a href="{{ route('checkout.direct', ['product_id' => $cartItems->first()->product_id]) }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-black font-bold py-2.5 px-6 rounded-xl shadow-md text-sm transition-all">
                                    Lanjut ke Pembayaran ⚡
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>