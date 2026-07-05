<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opening_balance',
        'closing_balance',
        'total_sales',
        'opened_at',
        'closed_at',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'opening_balance' => 'decimal:2',
            'closing_balance' => 'decimal:2',
            'total_sales' => 'decimal:2',
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    /**
     * Get the user who owns this shift.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all sales made during this shift.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Check if this shift is currently open.
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Scope: only open shifts.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Get formatted opening balance.
     */
    public function getFormattedOpeningBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->opening_balance, 0, ',', '.');
    }
}
