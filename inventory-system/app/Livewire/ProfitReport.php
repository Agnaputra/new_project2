<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class ProfitReport extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;

    public function mount()
    {
        // Default filter bulan ini
        $this->startDate = date('Y-m-01');
        $this->endDate = date('Y-m-t');
    }

    public function updatedStartDate() { $this->resetPage(); }
    public function updatedEndDate() { $this->resetPage(); }

    public function render()
    {
        $sales = Sale::query()
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->latest()
            ->paginate(10);

        // Menghitung total profit dari semua data (bukan hanya yang di-paginate)
        $summaryProfit = Sale::query()
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->sum('total_profit');

        return view('livewire.profit-report', [
            'sales' => $sales,
            'summaryProfit' => $summaryProfit
        ]);
    }
}