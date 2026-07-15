<x-app-layout>
    <div class="flex min-h-screen bg-gray-50" x-data="{ activeTab: 'analitik' }">
        
        <aside class="w-64 bg-white border-r border-gray-200 p-6 shrink-0">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6">Menu Navigasi</h3>
            <nav class="space-y-2">
                <button @click="activeTab = 'analitik'" :class="activeTab === 'analitik' ? 'bg-green-50 text-green-600 font-bold' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-xl text-sm transition cursor-pointer flex items-center gap-2">
                    📊 Laporan & Analitik
                </button>
                <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-green-50 text-green-600 font-bold' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-xl text-sm transition cursor-pointer flex items-center gap-2">
                    👥 Manajemen User & Kategori
                </button>
                <button @click="activeTab = 'pesanan'" :class="activeTab === 'pesanan' ? 'bg-green-50 text-green-600 font-bold' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-xl text-sm transition cursor-pointer flex items-center gap-2">
                    📦 Monitoring Pesanan
                </button>
                <button @click="activeTab = 'pengaturan'" :class="activeTab === 'pengaturan' ? 'bg-green-50 text-green-600 font-bold' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-3 rounded-xl text-sm transition cursor-pointer flex items-center gap-2">
                    ⚙️ Pengaturan Sistem
                </button>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            
            <div x-show="activeTab === 'analitik'">
                <h2 class="text-2xl font-black text-gray-900 mb-6">📊 Laporan & Ringkasan Analitik</h2>
                
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <h3 class="text-sm font-bold text-gray-700">🔔 Pemberitahuan Toko</h3>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="bg-red-500 text-white font-black text-[10px] px-2 py-0.5 rounded-full animate-bounce">
                                {{ auth()->user()->unreadNotifications->count() }} Baru
                            </span>
                        @endif
                    </div>

                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications as $notif)
                            <div class="p-3 bg-green-50 border-l-4 border-green-600 rounded-r-xl text-xs flex justify-between items-center">
                                <span class="font-medium text-green-800">{{ $notif->data['message'] }}</span>
                                <span class="text-[10px] text-gray-400 font-mono">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Belum ada pesanan atau aktivitas pembayaran baru dari pembeli pak.</p>
                        @endforelse
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                        <p class="text-xs font-medium text-gray-500 uppercase">Total Pengguna</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                        <p class="text-xs font-medium text-gray-500 uppercase">Total Produk Aktif</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $totalProducts ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                        <p class="text-xs font-medium text-gray-500 uppercase">Total Transaksi</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $totalTransactions ?? 0 }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 bg-gradient-to-br from-green-50 to-emerald-50 shadow-xs">
                        <p class="text-xs font-bold text-green-700 uppercase">Omset Bersih Platform</p>
                        <p class="text-2xl font-black text-green-600 mt-2">Rp {{ number_format($revenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'users'" style="display: none;">
                <h2 class="text-2xl font-black text-gray-900 mb-6">👥 Manajemen Data Master</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                        <h3 class="text-sm font-bold text-gray-700 mb-4">Daftar Pengguna Terdaftar</h3>
                        <table class="w-full border-collapse text-left text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500">
                                    <th class="p-2">Nama</th>
                                    <th class="p-2">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($allUsers) && count($allUsers) > 0)
                                    @foreach($allUsers as $user)
                                    <tr class="border-b border-gray-100">
                                        <td class="p-2 font-medium">{{ $user->name }}</td>
                                        <td class="p-2">
                                            <span class="px-2 py-0.5 rounded font-bold uppercase {{ $user->role === 'admin' ? 'bg-red-50 text-red-600' : ($user->role === 'seller' ? 'bg-orange-50 text-orange-600' : 'bg-blue-50 text-blue-600') }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="p-4 text-center text-gray-400 italic">Belum ada data pengguna pak.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                        <h3 class="text-sm font-bold text-gray-700 mb-4">Daftar Kategori Produk</h3>
                        <table class="w-full border-collapse text-left text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500">
                                    <th class="p-2">Nama Kategori</th>
                                    <th class="p-2">Slug</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($allCategories) && count($allCategories) > 0)
                                    @foreach($allCategories as $category)
                                    <tr class="border-b border-gray-100">
                                        <td class="p-2 font-medium">{{ $category->name }}</td>
                                        <td class="p-2 text-gray-400">{{ $category->slug }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="p-4 text-center text-gray-400 italic">Belum ada data kategori.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'pesanan'" style="display: none;">
                <h2 class="text-2xl font-black text-gray-900 mb-6">📦 Monitoring Transaksi Pesanan Global</h2>
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                    <table class="w-full border-collapse text-left text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500">
                                <th class="p-3">ID Resi</th>
                                <th class="p-3">Nama Pembeli</th>
                                <th class="p-3">Total Nominal</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($allTransactions) && count($allTransactions) > 0)
                                @foreach($allTransactions as $trx)
                                <tr class="border-b border-gray-100">
                                    <td class="p-3 font-mono text-gray-500">#TRX-{{ $trx->id }}</td>
                                    <td class="p-3 font-medium">{{ $trx->user->name ?? 'User Dihapus' }}</td>
                                    <td class="p-3 font-bold">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                    <td class="p-3"><span class="bg-green-50 text-green-600 font-bold px-2 py-0.5 rounded-lg uppercase">Success</span></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400 italic">Belum ada aktivitas belanja yang masuk.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="activeTab === 'pengaturan'" style="display: none;">
                <h2 class="text-2xl font-black text-gray-900 mb-6">⚙️ Pengaturan Konfigurasi Platform</h2>
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs max-w-xl">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Platform Marketplace</label>
                            <input type="text" value="TokoKita E-Commerce" disabled class="w-full text-xs px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status Operasional Web</label>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Mode Produksi Aktif (Online)
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</x-app-layout>