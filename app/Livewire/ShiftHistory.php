<?php

namespace App\Livewire;

use App\Models\CashShift;
use Livewire\Component;
use Livewire\WithPagination;

class ShiftHistory extends Component
{
    use WithPagination;

    public string $dateFrom = '';
    public string $dateTo = '';

    public function mount(): void
    {
        $this->dateFrom = now()->subDays(7)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $shifts = CashShift::with('user')
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('opened_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('opened_at', '<=', $this->dateTo);
            })
            ->orderBy('opened_at', 'desc')
            ->paginate(15);

        return view('livewire.shift-history', compact('shifts'))
            ->layout('layouts.admin');
    }
}
