<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Riwayat Transaksi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                        <div class="bg-white shadow-md rounded-2xl border-2 border-dashed border-gray-300 p-6 relative overflow-hidden">
                            
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