<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProfitReport extends Component
{
    public $startDate;
    public $endDate;
    public $totalProfit = 0;
    public $totalRevenue = 0;
    public $totalCost = 0;
    public $profitMargin = 0;
    public $dailyProfits = [];

    public function mount()
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadReport();
    }

    public function updatedStartDate()
    {
        $this->loadReport();
    }

    public function updatedEndDate()
    {
        $this->loadReport();
    }

    public function loadReport()
    {
        // Summary data
        $data = Sale::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->select(
                DB::raw('SUM(total_harga) as revenue'),
                DB::raw('SUM(total_profit) as profit')
            )
            ->first();

        $this->totalRevenue = $data->revenue ?? 0;
        $this->totalProfit = $data->profit ?? 0;
        $this->totalCost = $this->totalRevenue - $this->totalProfit;
        $this->profitMargin = $this->totalRevenue > 0 
            ? ($this->totalProfit / $this->totalRevenue) * 100 
            : 0;

        // Daily profits for chart
        $this->dailyProfits = Sale::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_profit) as profit'),
                DB::raw('SUM(total_harga) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => \Carbon\Carbon::parse($item->date)->format('d M'),
                    'profit' => (float) $item->profit,
                    'revenue' => (float) $item->revenue,
                ];
            })->toArray();
    }

    public function render()
    {
        return view('livewire.profit-report');
    }
}