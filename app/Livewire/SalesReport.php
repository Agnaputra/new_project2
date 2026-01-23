<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Carbon\Carbon;

class SalesReport extends Component
{
    use WithPagination;
    
    public $startDate;
    public $endDate;
    
    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }
    
    public function exportExcel()
    {
        return redirect()->route('reports.sales.export', [
            'start' => $this->startDate,
            'end' => $this->endDate
        ]);
    }
    
    #[Title('Laporan Penjualan')]
    public function render()
    {
        $sales = Sale::whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $totalSales = Sale::whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])->sum('total');
        
        $totalTransactions = Sale::whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])->count();
        
        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        
        return view('livewire.sales-report', [
            'sales' => $sales,
            'totalSales' => $totalSales,
            'totalTransactions' => $totalTransactions,
            'averageTransaction' => $averageTransaction,
        ])->layout('layouts.app');
    }
}