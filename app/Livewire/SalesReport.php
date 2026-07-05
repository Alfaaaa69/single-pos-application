<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class SalesReport extends Component
{
    use WithPagination;

    public string $dateFrom = '';
    public string $dateTo = '';
    public string $search = '';

    public function mount(): void
    {
        $this->dateFrom = now()->startOfDay()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $sales = Sale::with(['user', 'items'])
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalSales = $sales->sum('total');

        return view('livewire.sales-report', compact('sales', 'totalSales'))
            ->layout('layouts.admin');
    }
}
