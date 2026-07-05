<?php

namespace App\Livewire;

use App\Models\CashShift;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class PosTerminal extends Component
{
    // Search
    public string $search = '';

    // Cart: array of ['product_id', 'name', 'price', 'quantity', 'subtotal']
    public array $cart = [];

    // Payment
    public float $discountPercent = 0;
    public float $amountPaid = 0;
    public string $paymentMethod = 'cash';

    // Tax rate (PPN 11%)
    public float $taxRate = 11;

    // Active shift
    public ?int $activeShiftId = null;

    // UI state
    public bool $showPaymentModal = false;
    public ?int $lastSaleId = null;

    public function mount()
    {
        $this->loadActiveShift();
    }

    /**
     * Load the active shift for the current user.
     */
    public function loadActiveShift(): void
    {
        $shift = auth()->user()->activeShift();
        $this->activeShiftId = $shift?->id;
    }

    /**
     * Get filtered products based on search term.
     */
    #[Computed]
    public function products()
    {
        if (strlen($this->search) < 1) {
            return Product::active()
                ->with('category')
                ->orderBy('name')
                ->limit(20)
                ->get();
        }

        return Product::active()
            ->search($this->search)
            ->with('category')
            ->limit(20)
            ->get();
    }

    /**
     * Get all active categories.
     */
    #[Computed]
    public function categories()
    {
        return \App\Models\Category::active()->orderBy('name')->get();
    }

    /**
     * Add product to cart or increment quantity.
     */
    public function addToCart(int $productId): void
    {
        $product = Product::find($productId);

        if (!$product || !$product->is_active) {
            $this->dispatch('notify', type: 'error', message: 'Produk tidak ditemukan.');
            return;
        }

        $existingIndex = $this->findCartIndex($productId);

        if ($existingIndex !== null) {
            $newQty = $this->cart[$existingIndex]['quantity'] + 1;

            if (!$product->hasStock($newQty)) {
                $this->dispatch('notify', type: 'error', message: "Stok {$product->name} tidak mencukupi.");
                return;
            }

            $this->cart[$existingIndex]['quantity'] = $newQty;
            $this->cart[$existingIndex]['subtotal'] = $newQty * $this->cart[$existingIndex]['price'];
        } else {
            if (!$product->hasStock()) {
                $this->dispatch('notify', type: 'error', message: "Stok {$product->name} habis.");
                return;
            }

            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => 1,
                'subtotal' => (float) $product->price,
            ];
        }

        // Clear search after adding
        $this->search = '';
    }

    /**
     * Update item quantity in cart.
     */
    public function updateQuantity(int $index, int $quantity): void
    {
        if (!isset($this->cart[$index])) return;

        if ($quantity <= 0) {
            $this->removeFromCart($index);
            return;
        }

        $product = Product::find($this->cart[$index]['product_id']);
        if ($product && !$product->hasStock($quantity)) {
            $this->dispatch('notify', type: 'error', message: "Stok {$product->name} tidak mencukupi.");
            return;
        }

        $this->cart[$index]['quantity'] = $quantity;
        $this->cart[$index]['subtotal'] = $quantity * $this->cart[$index]['price'];
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart(int $index): void
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // Re-index
    }

    /**
     * Clear entire cart.
     */
    public function clearCart(): void
    {
        $this->cart = [];
        $this->discountPercent = 0;
        $this->amountPaid = 0;
    }

    /**
     * Calculate subtotal (before discount & tax).
     */
    #[Computed]
    public function subtotal(): float
    {
        return array_sum(array_column($this->cart, 'subtotal'));
    }

    /**
     * Calculate discount amount.
     */
    #[Computed]
    public function discountAmount(): float
    {
        return $this->subtotal() * ($this->discountPercent / 100);
    }

    /**
     * Calculate the amount after discount (before tax).
     */
    #[Computed]
    public function afterDiscount(): float
    {
        return $this->subtotal() - $this->discountAmount();
    }

    /**
     * Calculate tax amount.
     */
    #[Computed]
    public function taxAmount(): float
    {
        return $this->afterDiscount() * ($this->taxRate / 100);
    }

    /**
     * Calculate grand total.
     */
    #[Computed]
    public function total(): float
    {
        return $this->afterDiscount() + $this->taxAmount();
    }

    /**
     * Calculate change amount.
     */
    #[Computed]
    public function changeAmount(): float
    {
        return max(0, $this->amountPaid - $this->total());
    }

    /**
     * Open payment modal.
     */
    public function openPaymentModal(): void
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', type: 'error', message: 'Keranjang kosong.');
            return;
        }

        if (!$this->activeShiftId) {
            $this->dispatch('notify', type: 'error', message: 'Buka shift terlebih dahulu.');
            return;
        }

        $this->amountPaid = ceil($this->total());
        $this->showPaymentModal = true;
    }

    /**
     * Close payment modal.
     */
    public function closePaymentModal(): void
    {
        $this->showPaymentModal = false;
    }

    /**
     * Process the checkout.
     */
    public function checkout(): void
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', type: 'error', message: 'Keranjang kosong.');
            return;
        }

        if (!$this->activeShiftId) {
            $this->dispatch('notify', type: 'error', message: 'Buka shift terlebih dahulu.');
            return;
        }

        $total = $this->total();

        if ($this->paymentMethod === 'cash' && $this->amountPaid < $total) {
            $this->dispatch('notify', type: 'error', message: 'Jumlah bayar kurang.');
            return;
        }

        try {
            DB::transaction(function () use ($total) {
                // Create sale record
                $sale = Sale::create([
                    'user_id' => auth()->id(),
                    'cash_shift_id' => $this->activeShiftId,
                    'invoice_number' => Sale::generateInvoiceNumber(),
                    'subtotal' => $this->subtotal(),
                    'discount_amount' => $this->discountAmount(),
                    'tax_rate' => $this->taxRate,
                    'tax_amount' => $this->taxAmount(),
                    'total' => $total,
                    'amount_paid' => $this->paymentMethod === 'cash' ? $this->amountPaid : $total,
                    'change_amount' => $this->paymentMethod === 'cash' ? $this->changeAmount() : 0,
                    'payment_method' => $this->paymentMethod,
                ]);

                // Create sale items & decrement stock
                foreach ($this->cart as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'],
                        'product_name' => $item['name'],
                        'unit_price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    Product::where('id', $item['product_id'])
                        ->decrement('stock', $item['quantity']);
                }

                // Update shift total sales
                CashShift::where('id', $this->activeShiftId)
                    ->increment('total_sales', $total);

                $this->lastSaleId = $sale->id;
            });

            // Reset cart & payment
            $this->cart = [];
            $this->discountPercent = 0;
            $this->amountPaid = 0;
            $this->showPaymentModal = false;

            // Dispatch print event to browser
            $this->dispatch('print-receipt', saleId: $this->lastSaleId);
            $this->dispatch('notify', type: 'success', message: 'Transaksi berhasil!');

        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Reload shift after shift-manager updates.
     */
    #[On('shift-updated')]
    public function onShiftUpdated(): void
    {
        $this->loadActiveShift();
    }

    /**
     * Search by category filter.
     */
    public function filterByCategory(string $slug): void
    {
        $this->search = '';
    }

    /**
     * Find cart index by product ID.
     */
    private function findCartIndex(int $productId): ?int
    {
        foreach ($this->cart as $index => $item) {
            if ($item['product_id'] === $productId) {
                return $index;
            }
        }
        return null;
    }

    public function render()
    {
        return view('livewire.pos-terminal');
    }
}
