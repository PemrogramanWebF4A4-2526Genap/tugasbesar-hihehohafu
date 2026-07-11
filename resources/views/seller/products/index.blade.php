<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Produk Saya') }}
            </h2>
            <a href="{{ route('seller.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded shadow">
                + Tambah Produk
            </a>
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

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-200 p-2">Nama Produk</th>
                            <th class="border border-gray-200 p-2">Foto</th> <th class="border border-gray-200 p-2">Harga</th>
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
        @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>