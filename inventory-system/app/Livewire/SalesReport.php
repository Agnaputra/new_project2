<?php

namespace App\Livewire;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SalesReport extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $totalSales = 0;
    public $totalTransactions = 0;
    public $averageTransaction = 0;

    public function mount()
    {
        // Default: 30 hari terakhir
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $sales = Sale::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Calculate summary
        $summary = Sale::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->select(
                DB::raw('SUM(total_harga) as total_sales'),
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('AVG(total_harga) as average_transaction')
            )
            ->first();

        $this->totalSales = $summary->total_sales ?? 0;
        $this->totalTransactions = $summary->total_transactions ?? 0;
        $this->averageTransaction = $summary->average_transaction ?? 0;

        return view('livewire.sales-report', [
            'sales' => $sales
        ]);
    }
}