<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalRevenue = Sale::sum('total_sell');
        $totalProfit = Sale::sum('profit');
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();

        return response()->json([
            'total_products' => $totalProducts,
            'total_stock' => $totalStock,
            'total_revenue' => $totalRevenue,
            'total_profit' => $totalProfit,
            'low_stock_count' => $lowStockCount
        ]);
    }
}