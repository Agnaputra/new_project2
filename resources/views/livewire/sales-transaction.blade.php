<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">🛒 Transaksi Penjualan</h1>
        <p class="text-slate-600 mt-1">Point of Sale System</p>
    </div>

    @if (session()->has('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-lg mb-6 flex items-start">
            <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6 flex items-start">
            <svg class="w-5 h-5 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Product Search & Selection -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Search Product -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-900">Cari Produk</h3>
                </div>
                
                <input type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Ketik nama produk atau SKU..."
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-lg transition">

                @if($search && $products->count() > 0)
                <div class="mt-4 border border-slate-200 rounded-xl max-h-96 overflow-y-auto divide-y divide-slate-100">
                    @foreach($products as $product)
                    <div wire:click="selectProduct({{ $product->id }})" 
                        class="p-4 hover:bg-indigo-50 cursor-pointer transition-all duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-slate-900">{{ $product->nama }}</h4>
                                <p class="text-sm text-slate-500 mt-1">{{ $product->kategori }} • SKU: {{ $product->sku ?? '-' }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="font-semibold text-emerald-600">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                                    <span class="text-slate-400">•</span>
                                    <span class="text-sm text-slate-600">Stok: <span class="font-medium">{{ $product->stok }}</span></span>
                                </div>
                            </div>
                            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                                Pilih
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Selected Product Input -->
            @if($selectedProduct)
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Produk Dipilih
                </h3>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 mb-4 border border-white/20">
                    <h4 class="font-bold text-xl">{{ $selectedProduct->nama }}</h4>
                    <p class="text-indigo-100">{{ $selectedProduct->kategori }}</p>
                    <div class="flex justify-between mt-3 text-sm">
                        <span>Harga: <strong>Rp {{ number_format($selectedProduct->harga_jual, 0, ',', '.') }}</strong></span>
                        <span>Stok: <strong>{{ $selectedProduct->stok }}</strong></span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Jumlah</label>
                        <input type="number" wire:model="quantity" min="1" max="{{ $selectedProduct->stok }}"
                            class="w-full px-4 py-2 rounded-xl text-slate-900 font-bold text-lg border-2 border-white/20 focus:border-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Subtotal</label>
                        <div class="bg-white/20 px-4 py-2 rounded-xl font-bold text-lg border-2 border-white/20">
                            Rp {{ number_format($selectedProduct->harga_jual * $quantity, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <button wire:click="addToCart" 
                    class="w-full mt-4 bg-white text-indigo-600 hover:bg-indigo-50 py-3 rounded-xl font-bold transition-all transform hover:scale-105">
                    + Tambah ke Keranjang
                </button>
            </div>
            @endif

            <!-- Shopping Cart -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Keranjang Belanja
                </h3>
                
                @if(count($cart) > 0)
                <div class="space-y-3">
                    @foreach($cart as $index => $item)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100 hover:border-indigo-200 transition">
                        <div class="flex-1">
                            <h4 class="font-semibold text-slate-900">{{ $item['nama'] }}</h4>
                            <p class="text-sm text-slate-600 mt-1">
                                Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }} × {{ $item['quantity'] }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <p class="font-bold text-slate-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                <p class="text-xs text-emerald-600">Profit: Rp {{ number_format($item['total_profit'], 0, ',', '.') }}</p>
                            </div>
                            <button wire:click="removeFromCart({{ $index }})" 
                                class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-slate-400">
                    <svg class="mx-auto h-16 w-16 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <p class="font-medium">Keranjang masih kosong</p>
                    <p class="text-sm mt-1">Pilih produk untuk memulai transaksi</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Summary & Checkout -->
        <div class="space-y-6">
            <!-- Summary Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Ringkasan
                </h3>
                
                <div class="space-y-4 mb-6 pb-6 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Total Item</span>
                        <span class="font-semibold text-slate-900">{{ count($cart) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Total Quantity</span>
                        <span class="font-semibold text-slate-900">{{ collect($cart)->sum('quantity') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                        <span class="font-semibold text-slate-900">Total Harga</span>
                        <span class="font-bold text-2xl text-slate-900">
                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-emerald-600">Total Profit</span>
                        <span class="font-bold text-lg text-emerald-600">
                            Rp {{ number_format($totalProfit, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Customer (Opsional)</label>
                        <input type="text" wire:model="customerName" 
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                        <textarea wire:model="notes" rows="2"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            placeholder="Catatan transaksi..."></textarea>
                    </div>
                </div>

                <button wire:click="completeSale" 
                    @if(count($cart) == 0) disabled @endif
                    class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 disabled:from-slate-300 disabled:to-slate-400 text-white py-4 rounded-xl font-bold transition-all transform hover:scale-105 disabled:hover:scale-100 disabled:cursor-not-allowed shadow-lg hover:shadow-xl">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Selesaikan Transaksi
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>