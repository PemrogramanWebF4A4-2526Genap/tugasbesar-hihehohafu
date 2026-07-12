<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Riwayat Transaksi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl font-bold text-sm border border-green-200 shadow-xs">
                    🎉 {{ session('success') }}
                </div>
            @endif

            <h3 class="text-xl font-black text-gray-950 mb-6">🧾 Resi Pembelian Anda</h3>

            @if($transactions->isEmpty())
                <div class="bg-white shadow-xs rounded-2xl p-8 text-center border border-gray-200">
                    <span class="text-5xl">📭</span>
                    <p class="text-gray-500 text-sm mt-3">Anda belum memiliki resi transaksi pembayaran.</p>
                    <a href="{{ url('/') }}" class="inline-block mt-4 text-sm font-bold text-blue-600 hover:underline">Mulai Belanja &rarr;</a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($transactions as $tx)
                        <div class="bg-white shadow-md rounded-2xl border-2 border-dashed border-gray-300 p-6 relative overflow-hidden mb-6">
                            
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gray-200 block"></div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4 mb-4 gap-2">
                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase">NOMOR RESI / INVOICE</span>
                                    <h4 class="text-lg font-black text-gray-900">#TK-{{ str_pad($tx->id, 6, '0', STR_PAD_LEFT) }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Waktu Transaksi: {{ $tx->created_at->format('d M Y, H:i') }} WIB</p>
                                </div>
                                <div>
                                    <span class="px-3 py-1.5 text-xs font-black rounded-xl uppercase tracking-wider bg-green-100 text-green-800 border border-green-200">
                                        {{ $tx->status == 'success' ? 'LUNAS / PAID' : $tx->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                <div class="flex justify-between items-center text-sm mb-2">
                                    <span class="text-gray-500">Metode Pembayaran:</span>
                                    <span class="font-bold text-gray-800">Saldo TokoKita (Dummy)</span>
                                </div>
                                <div class="flex justify-between items-center text-sm mb-2">
                                    <span class="text-gray-500">Status Pengiriman:</span>
                                    <span class="font-black text-orange-600">Menunggu Konfirmasi Penjual</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-2 flex justify-between items-center">
                                    <span class="text-base font-bold text-gray-900">Total Dibayar:</span>
                                    <span class="text-lg font-black text-green-600">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4 mt-4 mb-4">
                                @php
                                    $review = \App\Models\Review::find($tx->id);
                                @endphp

                                @if($review)
                                    @php
                                        // Mengambil isi teks ulasan dari kolom pertama yang bukan ID atau Timestamp pak
                                        $reviewText = collect($review->getAttributes())->except(['id', 'created_at', 'updated_at', 'transaction_id', 'user_id', 'product_id'])->first();
                                    @endphp
                                    @if($reviewText)
                                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-sm">
                                            <span class="font-bold text-blue-800 block">💬 Ulasan Kalimat Anda:</span>
                                            <p class="text-gray-700 italic mt-0.5">"{{ $reviewText }}"</p>
                                        </div>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('buyer.review.store') }}" class="space-y-2">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ $tx->id }}">
                                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block">✍ Berikan Ulasan Pembelian (Kalimat):</label>
                                        <div class="flex gap-2">
                                            <input type="text" name="comment" placeholder="Ketik review di sini pak (contoh: Mantap barangnya cepat sampai)..." class="w-full text-sm border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl px-4 py-2 text-gray-900 bg-white" required>
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-black px-4 rounded-xl transition cursor-pointer shrink-0">
                                                Kirim Ulasan
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-400 italic">
                                <span>* Resi otomatis terkirim ke Inbox Toko Penjual</span>
                                <span class="text-gray-300">TokoKita Inc.</span>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>