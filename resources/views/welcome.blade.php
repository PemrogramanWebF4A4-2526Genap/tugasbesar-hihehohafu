<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace Toko Kita</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-900">

    <nav class="bg-white shadow-sm p-4 sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-green-600 tracking-tight">Toko<span class="text-orange-500">Kita</span></a>
            
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-green-600 font-semibold text-sm bg-gray-100 py-2 px-4 rounded-lg transition">
                        Ke Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-bold text-sm border border-green-600 py-2 px-4 rounded-lg transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold text-sm py-2 px-4 rounded-lg transition shadow-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-2xl p-8 shadow-sm">
            <h1 class="text-3xl font-extrabold mb-2">UAS Marketplace E-Commerce</h1>
            <p class="text-green-50">Belanja produk berkualitas dari penjual terpercaya langsung di platform kami.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            ✨ Rekomendasi Produk Untukmu
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($products as $product)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col justify-between hover:shadow-md transition duration-200">
                    <div>
                        <div class="relative bg-gray-100 aspect-square">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">Tidak ada foto</div>
                            @endif
                        </div>
                        
                        <div class="p-3">
                            <span class="text-[10px] font-bold text-green-600 uppercase bg-green-50 px-2 py-0.5 rounded">
                                {{ $product->category->name ?? 'Umum' }}
                            </span>
                            <h3 class="text-sm font-medium mt-2 text-gray-800 line-clamp-2 min-h-[40px]">{{ $product->name }}</h3>
                            <div class="text-base font-bold text-gray-900 mt-1">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3 pt-0">
                        @auth
                            <div class="flex flex-col gap-2">
                                <button type="button" onclick="openCartModal('{{ $product->id }}', '{{ $product->name }}')" class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 rounded-lg transition cursor-pointer">
                                    🛒 + Keranjang
                                </button>
                                
                                <a href="{{ route('checkout.direct', ['product_id' => $product->id]) }}" class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 rounded-lg transition">
                                    ⚡ Beli Sekarang
                                </a>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="block text-center w-full bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold py-2.5 rounded-lg transition shadow-xs">
                                Beli
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 text-gray-400">
                    Belum ada produk jualan yang tersedia di etalase toko.
                </div>
            @endforelse
        </div>
    </div>

    <div id="cartModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm mx-4 relative shadow-2xl transform scale-95 transition-transform duration-300">
            <button onclick="closeCartModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 font-bold text-xl cursor-pointer">&times;</button>
            
            <h3 class="text-base font-bold text-gray-900 pr-6 mb-1">Pilih Jumlah Barang</h3>
            <p id="modalProductName" class="text-sm text-gray-600 mb-6 font-medium"></p>
            
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">
                
                <div class="flex items-center justify-center gap-4 mb-6">
                    <button type="button" onclick="adjustModalQty(-1)" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-bold text-lg cursor-pointer">-</button>
                    <input type="number" name="quantity" id="modalQtyInput" value="1" min="1" class="w-16 text-center font-black text-xl text-gray-900 bg-gray-50 border border-gray-300 rounded-xl py-1.5 focus:outline-none">
                    <button type="button" onclick="adjustModalQty(1)" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl font-bold text-lg cursor-pointer">+</button>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeCartModal()" class="w-1/2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-xl text-sm transition cursor-pointer">Batal</button>
                    <button type="submit" class="w-1/2 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-sm cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCartModal(productId, productName) {
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').innerText = productName;
            document.getElementById('modalQtyInput').value = 1;
            
            const modal = document.getElementById('cartModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        function closeCartModal() {
            const modal = document.getElementById('cartModal');
            modal.classList.remove('opacity-100');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function adjustModalQty(amount) {
            const input = document.getElementById('modalQtyInput');
            let currentVal = parseInt(input.value) || 1;
            currentVal += amount;
            if (currentVal < 1) currentVal = 1;
            input.value = currentVal;
        }
    </script>
</body>
</html>