<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $stats = [];
    public $categoryDistribution = [];
    public $weeklySales = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadCategoryDistribution();
        $this->loadWeeklySales();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_products' => Product::count(),
            'total_stock' => Product::sum('stok'),
            'total_sales' => Sale::sum('total_harga'),
            'total_profit' => Sale::sum('total_profit'),
            'low_stock_count' => Product::lowStock()->count(),
            'today_sales' => Sale::whereDate('created_at', today())->sum('total_harga'),
            'today_profit' => Sale::whereDate('created_at', today())->sum('total_profit'),
        ];
    }

    public function loadCategoryDistribution()
    {
        $this->categoryDistribution = Product::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->kategori,
                    'value' => $item->total,
                ];
            })->toArray();
    }

    public function loadWeeklySales()
    {
        $this->weeklySales = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_harga) as sales'),
            DB::raw('SUM(total_profit) as profit')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'sales' => (float) $item->sales,
                    'profit' => (float) $item->profit,
                ];
            })->toArray();
    }

    public function render()
{
    return view('livewire.dashboard')
        ->layout('layouts.app');
}

}