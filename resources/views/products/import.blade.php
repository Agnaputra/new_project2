<x-layouts.app>
    <x-slot name="header">Import Produk</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">📥 Import Data Produk dari Excel</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Template Download -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">📋 Format Template Excel</h3>
                <p class="text-sm text-blue-700 mb-3">
                    Download template Excel berikut dan isi data produk Anda:
                </p>
                <table class="text-xs border border-blue-200 w-full mb-3">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border border-blue-200 px-2 py-1">nama</th>
                            <th class="border border-blue-200 px-2 py-1">kategori</th>
                            <th class="border border-blue-200 px-2 py-1">harga_beli</th>
                            <th class="border border-blue-200 px-2 py-1">margin</th>
                            <th class="border border-blue-200 px-2 py-1">stok</th>
                            <th class="border border-blue-200 px-2 py-1">stok_minimum</th>
                            <th class="border border-blue-200 px-2 py-1">sku</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="border border-blue-200 px-2 py-1">Laptop ASUS</td>
                            <td class="border border-blue-200 px-2 py-1">Elektronik</td>
                            <td class="border border-blue-200 px-2 py-1">5000000</td>
                            <td class="border border-blue-200 px-2 py-1">30</td>
                            <td class="border border-blue-200 px-2 py-1">10</td>
                            <td class="border border-blue-200 px-2 py-1">3</td>
                            <td class="border border-blue-200 px-2 py-1">LAP-001</td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-xs text-blue-600">
                    💡 <strong>Margin</strong> dalam persen (contoh: 30 = 30%). Harga jual akan dihitung otomatis.
                </p>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('products.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih File Excel
                    </label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition">
                    <p class="text-xs text-gray-500 mt-2">Format: .xlsx, .xls, atau .csv (Max: 2MB)</p>
                    @error('file')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex space-x-3">
                    <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition">
                        📤 Upload & Import
                    </button>
                    <a href="{{ route('products.index') }}" 
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>