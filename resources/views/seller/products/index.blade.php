<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Produk Saya') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6 flex justify-between items-center gap-4">
                    <form action="{{ route('seller.products.index') }}" method="GET" class="flex items-center gap-2 w-full max-w-md">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk jualan..." class="w-full text-sm px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-900">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl text-sm transition cursor-pointer shrink-0">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('seller.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-xl text-sm transition text-center shrink-0">
                                Reset
                            </a>
                        @endif
                    </form>
                    
                    <a href="{{ route('seller.products.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-xl text-sm transition whitespace-nowrap">
                        + Tambah Produk
                    </a>
                </div>

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-200 p-2">Nama Produk</th>
                            <th class="border border-gray-200 p-2">Foto</th>
                            <th class="border border-gray-200 p-2">Harga</th>
                            <th class="border border-gray-200 p-2">Stok</th>
                            <th class="border border-gray-200 p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="border border-gray-200 p-2">{{ $product->name }}</td>
                                
                                <td class="border border-gray-200 p-2 text-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover mx-auto rounded">
                                    @else
                                        <span class="text-gray-400 text-sm">No Image</span>
                                    @endif
                                </td>
                                
                                <td class="border border-gray-200 p-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="border border-gray-200 p-2">{{ $product->stock }}</td>
                                <td class="border border-gray-200 p-2 text-center">-</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-200 p-4 text-center text-gray-500 italic text-sm">
                                    Tidak ada produk yang cocok dengan pencarian Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>