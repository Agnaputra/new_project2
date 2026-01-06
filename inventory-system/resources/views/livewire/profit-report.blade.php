<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuntungan (Profit)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="text-sm opacity-80 uppercase font-bold">Total Keuntungan Periode Ini</div>
                    <div class="text-3xl font-extrabold mt-1">Rp {{ number_format($summaryProfit, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-500">
                <div class="flex flex-col md:flex-row justify-end gap-4 mb-6">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-bold text-gray-600">Periode:</label>
                        <input wire:model.live="startDate" type="date" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <span class="text-gray-400">s/d</span>
                        <input wire:model.live="endDate" type="date" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">No. Invoice</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Total Penjualan</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Keuntungan</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Margin (%)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($sales as $sale)
                                @php 
                                    $margin = $sale->total_harga > 0 ? ($sale->total_profit / $sale->total_harga) * 100 : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $sale->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $sale->invoice_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        Rp {{ number_format($sale->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 font-bold">
                                        Rp {{ number_format($sale->total_profit, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                            {{ number_format($margin, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                                        Data transaksi tidak ditemukan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</div>