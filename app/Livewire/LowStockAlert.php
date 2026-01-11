<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class LowStockAlert extends Component
{
    public function render()
    {
        $lowStockProducts = Product::lowStock()
            ->orderBy('stok', 'asc')
            ->get();

        return view('livewire.low-stock-alert', [
            'products' => $lowStockProducts
        ]);
    }
}