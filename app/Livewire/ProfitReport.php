<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;
use Livewire\Attributes\Title;
use Carbon\Carbon;

class ProfitReport extends Component
{
    public $startDate;
    public $endDate;
    
    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }
    
    public function loadReport()
    {
        $this->dispatch('refreshChart');
    }
    
    public function exportExcel()
    {
        return redirect()->route('reports.profit.export', [
            'start' => $this->startDate,
            'end' => $this->endDate
        ]);
    }
    
    #[Title('Laporan Profit')]
    public function render()
    {
        $sales = Sale::whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])->get();
        
        $totalProfit = $sales->sum('profit');
        $totalRevenue = $sales->sum('total');
        $totalCost = $totalRevenue - $totalProfit;
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;
        
        // Daily profits for chart
        $dailyProfits = [];
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $daySales = Sale::whereDate('created_at', $date)->get();
            $dailyProfits[] = [
                'date' => $date->format('d M'),
                'profit' => $daySales->sum('profit'),
                'revenue' => $daySales->sum('total'),
            ];
        }
        
        return view('livewire.profit-report', [
            'totalProfit' => $totalProfit,
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'profitMargin' => $profitMargin,
            'dailyProfits' => $dailyProfits,
        ])->layout('layouts.app');
    }
}