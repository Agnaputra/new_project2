<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">🔴 Produk Stok Rendah</h3>
    
    @if($products->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Minimum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $product->nama }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                            {{ $product->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-bold {{ $product->stok == 0 ? 'text-red-600' : 'text-orange-600' }}">
                            {{ $product->stok }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $product->stok_minimum }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($product->stok == 0)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                Habis
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                Menipis
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="mt-2 text-sm text-gray-500">Semua produk memiliki stok yang cukup! 🎉</p>
    </div>
    @endif
</div>