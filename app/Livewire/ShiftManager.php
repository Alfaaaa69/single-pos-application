<?php

namespace App\Livewire;

use App\Models\CashShift;
use Livewire\Component;

class ShiftManager extends Component
{
    public bool $showModal = false;
    public float $openingBalance = 0;
    public float $closingBalance = 0;
    public string $notes = '';

    public ?CashShift $activeShift = null;

    public function mount()
    {
        $this->loadActiveShift();
    }

    /**
     * Load the current user's active shift.
     */
    public function loadActiveShift(): void
    {
        $this->activeShift = auth()->user()
            ->cashShifts()
            ->open()
            ->latest()
            ->first();
    }

    /**
     * Open the shift modal.
     */
    public function openModal(): void
    {
        $this->showModal = true;
    }

    /**
     * Close the shift modal.
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['openingBalance', 'closingBalance', 'notes']);
    }

    /**
     * Open a new cash shift.
     */
    public function openShift(): void
    {
        if ($this->activeShift) {
            $this->dispatch('notify', type: 'error', message: 'Masih ada shift aktif. Tutup shift terlebih dahulu.');
            return;
        }

        $this->validate([
            'openingBalance' => 'required|numeric|min:0',
        ]);

        $shift = CashShift::create([
            'user_id' => auth()->id(),
            'opening_balance' => $this->openingBalance,
            'opened_at' => now(),
            'status' => 'open',
        ]);

        $this->activeShift = $shift;
        $this->closeModal();
        $this->dispatch('shift-updated');
        $this->dispatch('notify', type: 'success', message: 'Shift berhasil dibuka.');
    }

    /**
     * Close the current active shift.
     */
    public function closeShift(): void
    {
        if (!$this->activeShift) {
            $this->dispatch('notify', type: 'error', message: 'Tidak ada shift aktif.');
            return;
        }

        $this->validate([
            'closingBalance' => 'required|numeric|min:0',
        ]);

        $this->activeShift->update([
            'closing_balance' => $this->closingBalance,
            'closed_at' => now(),
            'status' => 'closed',
            'notes' => $this->notes,
        ]);

        $this->activeShift = null;
        $this->closeModal();
        $this->dispatch('shift-updated');
        $this->dispatch('notify', type: 'success', message: 'Shift berhasil ditutup.');
    }

    public function render()
    {
        return view('livewire.shift-manager');
    }
}
