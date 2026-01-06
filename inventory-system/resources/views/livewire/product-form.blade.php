<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $isEdit ? '✏️ Edit Produk' : '➕ Tambah Produk Baru' }}
        </h2>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Row 1: Nama & Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk *</label>
                    <input type="text" wire:model="nama" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Contoh: Laptop ASUS ROG">
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select wire:model="kategori" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Alat Tulis">Alat Tulis</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 2: Harga Beli, Margin, Harga Jual (Excel-like Calculation) -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">💰 Perhitungan Harga (Otomatis)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Beli *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" wire:model.live="harga_beli" 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="0" step="0.01">
                        </div>
                        @error('harga_beli') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Margin *</label>
                        <div class="relative">
                            <input type="number" wire:model.live="margin" 
                                class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="30" step="0.01">
                            <span class="absolute right-3 top-2.5 text-gray-500">%</span>
                        </div>
                        @error('margin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Jual 
                            <span class="text-xs text-green-600">(Otomatis)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="text" 
                                value="{{ number_format($harga_jual, 0, ',', '.') }}" 
                                class="w-full pl-10 pr-4 py-2 bg-green-50 border border-green-300 rounded-lg font-bold text-green-700"
                                readonly>
                        </div>
                        @if($harga_jual && $harga_beli)
                        <p class="text-xs text-green-600 mt-1">
                            Profit per unit: Rp {{ number_format($harga_jual - $harga_beli, 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                </div>
                <p class="text-xs text-gray-600 mt-3">
                    📝 Rumus: <code class="bg-gray-200 px-2 py-1 rounded">Harga Jual = Harga Beli × (1 + Margin/100)</code>
                </p>
            </div>

            <!-- Row 3: Stok & Stok Minimum -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Awal *</label>
                    <input type="number" wire:model="stok" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="0">
                    @error('stok') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Minimum *</label>
                    <input type="number" wire:model="stok_minimum" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="5">
                    @error('stok_minimum') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Alert akan muncul jika stok mencapai atau di bawah nilai ini</p>
                </div>
            </div>

            <!-- Row 4: SKU (Optional) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SKU (Opsional)</label>
                <input type="text" wire:model="sku" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: PROD-001">
                @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Row 5: Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea wire:model="deskripsi" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="Detail produk..."></textarea>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('products.index') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    {{ $isEdit ? 'Update Produk' : 'Simpan Produk' }}
                </button>
            </div>
        </form>
    </div>
</div>