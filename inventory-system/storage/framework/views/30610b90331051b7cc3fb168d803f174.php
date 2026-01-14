<div class="p-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Produk -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Produk</p>
                    <p class="text-3xl font-bold mt-2"><?php echo e(number_format($stats['total_products'])); ?></p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Stok</p>
                    <p class="text-3xl font-bold mt-2"><?php echo e(number_format($stats['total_stock'])); ?></p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Penjualan</p>
                    <p class="text-3xl font-bold mt-2">Rp <?php echo e(number_format($stats['total_sales'], 0, ',', '.')); ?></p>
                    <p class="text-purple-100 text-xs mt-1">Hari ini: Rp <?php echo e(number_format($stats['today_sales'], 0, ',', '.')); ?></p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Total Profit</p>
                    <p class="text-3xl font-bold mt-2">Rp <?php echo e(number_format($stats['total_profit'], 0, ',', '.')); ?></p>
                    <p class="text-yellow-100 text-xs mt-1">Hari ini: Rp <?php echo e(number_format($stats['today_profit'], 0, ',', '.')); ?></p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Stok Rendah -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stats['low_stock_count'] > 0): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1">
                <p class="font-semibold text-red-800">⚠️ Peringatan Stok Rendah!</p>
                <p class="text-sm text-red-700">Terdapat <span class="font-bold"><?php echo e($stats['low_stock_count']); ?></span> produk dengan stok di bawah minimum.</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Lihat Detail
            </a>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Pie Chart: Distribusi Kategori -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Distribusi Kategori Produk</h3>
            <canvas id="categoryChart" class="w-full" style="max-height: 300px;"></canvas>
        </div>

        <!-- Line Chart: Performa Penjualan -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Performa Penjualan (7 Hari Terakhir)</h3>
            <canvas id="salesChart" class="w-full" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Low Stock Products Table -->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('low-stock-alert');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-4200423393-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category Distribution Pie Chart
            const categoryData = <?php echo json_encode($categoryDistribution, 15, 512) ?>;
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: categoryData.map(item => item.label),
                    datasets: [{
                        data: categoryData.map(item => item.value),
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', 
                            '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            // Weekly Sales Line Chart
            const salesData = <?php echo json_encode($weeklySales, 15, 512) ?>;
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesData.map(item => item.date),
                    datasets: [
                        {
                            label: 'Penjualan',
                            data: salesData.map(item => item.sales),
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Profit',
                            data: salesData.map(item => item.profit),
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</div><?php /**PATH C:\laragon\www\new_project2\inventory-system\resources\views/livewire/dashboard.blade.php ENDPATH**/ ?>