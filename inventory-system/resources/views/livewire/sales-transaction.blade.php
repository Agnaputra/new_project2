<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">🛒 Transaksi Penjualan</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Product Search & Selection -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Search Product -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🔍 Cari Produk</h3>
                
                <input type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Ketik nama produk atau SKU..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg">

                @if($search && $products->count() > 0)
                <div class="mt-4 border border-gray-200 rounded-lg max-h-96 overflow-y-auto">
                    @foreach($products as $product)
                    <div wire:click="selectProduct({{ $product->id }})" 
                        class="p-4 hover:bg-blue-50 cursor-pointer border-b last:border-b-0 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $product->nama }}</h4>
                                <p class="text-sm text-gray-500">{{ $product->kategori }} • SKU: {{ $product->sku ?? '-' }}</p>
                                <p class="text-sm mt-1">
                                    <span class="font-medium text-green-600">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                                    <span class="text-gray-400 mx-2">|</span>
                                    <span class="text-gray-600">Stok: {{ $product->stok }}</span>
                                </p>
                            </div>
                            <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition">
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
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4">✅ Produk Dipilih</h3>
                <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-4">
                    <h4 class="font-bold text-xl">{{ $selectedProduct->nama }}</h4>
                    <p class="text-blue-100">{{ $selectedProduct->kategori }}</p>
                    <div class="flex justify-between mt-3 text-sm">
                        <span>Harga: <strong>Rp {{ number_format($selectedProduct->harga_jual, 0, ',', '.') }}</strong></span>
                        <span>Stok: <strong>{{ $selectedProduct->stok }}</strong></span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Jumlah</label>
                        <input type="number" wire:model="quantity" min="1" max="{{ $selectedProduct->stok }}"
                            class="w-full px-4 py-2 rounded-lg text-gray-800 font-bold text-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Subtotal</label>
                        <div class="bg-white bg-opacity-30 px-4 py-2 rounded-lg font-bold text-lg">
                            Rp {{ number_format($selectedProduct->harga_jual * $quantity, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <button wire:click="addToCart" 
                    class="w-full mt-4 bg-white text-blue-600 hover:bg-blue-50 py-3 rounded-lg font-bold transition">
                    + Tambah ke Keranjang
                </button>
            </div>
            @endif

            <!-- Shopping Cart -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🛍️ Keranjang Belanja</h3>
                
                @if(count($cart) > 0)
                <div class="space-y-3">
                    @foreach($cart as $index => $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">{{ $item['nama'] }}</h4>
                            <p class="text-sm text-gray-600">
                                Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }} × {{ $item['quantity'] }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="font-bold text-gray-800">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                <p class="text-xs text-green-600">Profit: Rp {{ number_format($item['total_profit'], 0, ',', '.') }}</p>
                            </div>
                            <button wire:click="removeFromCart({{ $index }})" 
                                class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-400">
                    <svg class="mx-auto h-16 w-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <p>Keranjang masih kosong</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Summary & Checkout -->
        <div class="space-y-6">
            <!-- Summary Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Ringkasan</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Total Item</span>
                        <span class="font-semibold">{{ count($cart) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Total Quantity</span>
                        <span class="font-semibold">{{ collect($cart)->sum('quantity') }}</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between">
                        <span class="font-semibold text-gray-800">Total Harga</span>
                        <span class="font-bold text-xl text-gray-800">
                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between text-green-600">
                        <span class="font-semibold">Total Profit</span>
                        <span class="font-bold text-lg">
                            Rp {{ number_format($totalProfit, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="space-y-3 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer (Opsional)</label>
                        <input type="text" wire:model="customerName" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea wire:model="notes" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Catatan transaksi..."></textarea>
                    </div>
                </div>

                <button wire:click="completeSale" 
                    @if(count($cart) == 0) disabled @endif
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 disabled:from-gray-300 disabled:to-gray-400 text-white py-3 rounded-lg font-bold transition">
                    ✅ Selesaikan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>