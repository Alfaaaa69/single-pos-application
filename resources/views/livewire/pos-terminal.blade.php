<div class="min-h-[calc(100vh-100px)]">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- ============================================== -->
        <!-- LEFT COLUMN: Products Selection                -->
        <!-- ============================================== -->
        <div class="lg:col-span-2 space-y-5">
            <!-- Search & Filter Controls -->
            <div class="bg-slate-900 p-5 rounded-2xl shadow-lg border border-slate-800/80">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="block w-full rounded-xl border-slate-700 bg-slate-800/80 pl-11 pr-4 py-3 text-sm text-slate-200 placeholder-slate-450 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-slate-800 transition-all duration-200"
                               placeholder="Cari produk berdasarkan nama, SKU, atau scan barcode..."
                               autofocus>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @forelse($this->products as $product)
                    <button type="button"
                            wire:click="addToCart({{ $product->id }})"
                            @if($product->stock <= 0) disabled @endif
                            class="group text-left bg-slate-800 border border-slate-700/65 rounded-2xl overflow-hidden shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:ring-offset-2 focus:ring-offset-slate-900 flex flex-col h-full relative {{ $product->stock <= 0 ? 'opacity-45 cursor-not-allowed grayscale' : 'hover:-translate-y-1.5 hover:shadow-xl hover:shadow-indigo-950/80 hover:border-indigo-500/50 cursor-pointer' }}">

                        {{-- Stock Status Badge --}}
                        @if($product->stock <= 0)
                            <span class="absolute top-2.5 right-2.5 bg-gradient-to-r from-red-600 to-rose-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider z-10 shadow-md shadow-red-950/65">Habis</span>
                        @elseif($product->stock <= 5)
                            <span class="absolute top-2.5 right-2.5 bg-gradient-to-r from-amber-500 to-orange-400 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider z-10 shadow-md shadow-amber-950/65">Sisa {{ $product->stock }}</span>
                        @endif

                        <!-- Product Image Area — dark tint blending transparent images perfectly -->
                        <div class="h-32 bg-slate-900/90 flex items-center justify-center text-slate-500 border-b border-slate-700/60 overflow-hidden relative">
                            @if($product->image)
                                <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-contain transition-transform duration-500 ease-out group-hover:scale-110">
                            @else
                                <div class="flex items-center justify-center h-full w-full">
                                    <svg class="h-10 w-10 text-slate-650 transition-all duration-300 group-hover:scale-110 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex-1 flex flex-col justify-between bg-slate-800">
                            <div>
                                {{-- Category Pill --}}
                                <span class="inline-flex items-center text-[10px] font-bold text-indigo-300 bg-indigo-950/65 border border-indigo-900/60 px-2.5 py-0.5 rounded-full uppercase tracking-widest mb-1.5">
                                    {{ $product->category->name }}
                                </span>
                                <h3 class="font-bold text-slate-150 text-sm line-clamp-2 leading-snug">
                                    {{ $product->name }}
                                </h3>
                                <span class="text-[10px] text-slate-400 block mt-1 font-mono tracking-wide">SKU: {{ $product->sku }}</span>
                            </div>
                            <div class="mt-3 flex justify-between items-end">
                                <span class="font-black text-emerald-400 text-base tracking-tight">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                {{-- Stock Badge --}}
                                @if($product->stock > 10)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-450 bg-emerald-950/60 border border-emerald-900/60 px-2 py-0.5 rounded-full">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        {{ $product->stock }}
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-400 bg-amber-950/60 border border-amber-900/60 px-2 py-0.5 rounded-full">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-400 bg-red-950/60 border border-red-900/60 px-2 py-0.5 rounded-full">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        0
                                    </span>
                                @endif
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full bg-slate-900/60 backdrop-blur-sm p-14 rounded-2xl border border-slate-800 text-center shadow-lg">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-slate-850 border border-slate-700/60 mb-4">
                            <svg class="h-8 w-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-slate-200 font-semibold">Tidak ada produk ditemukan.</p>
                        <p class="text-slate-450 text-sm mt-1">Coba ubah kata kunci pencarian Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ============================================== -->
        <!-- RIGHT COLUMN: Dark Premium Cart Panel          -->
        <!-- ============================================== -->
        <div class="bg-slate-900 rounded-2xl shadow-2xl shadow-slate-950/50 flex flex-col h-[calc(100vh-140px)] sticky top-6 overflow-hidden ring-1 ring-slate-800/80">
            <!-- Cart Header -->
            <div class="p-5 border-b border-slate-850 flex justify-between items-center bg-gradient-to-r from-slate-900 to-slate-850">
                <h2 class="font-bold text-slate-100 text-lg flex items-center">
                    <span class="flex items-center justify-center h-9 w-9 rounded-xl bg-indigo-600/20 ring-1 ring-indigo-500/30 mr-3">
                        <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                    Keranjang
                    @if(!empty($cart))
                        <span class="ml-2.5 bg-gradient-to-r from-indigo-500 to-violet-500 text-white text-xs font-bold px-2.5 py-0.5 rounded-full min-w-[24px] text-center shadow-lg shadow-indigo-500/30">{{ count($cart) }}</span>
                    @endif
                </h2>
                <button wire:click="clearCart"
                        @if(empty($cart)) disabled @endif
                        class="text-xs text-red-400 hover:text-red-300 disabled:opacity-30 disabled:cursor-not-allowed font-semibold px-3 py-1.5 rounded-lg hover:bg-red-500/10 transition-all duration-200 border border-transparent hover:border-red-500/20">
                    Bersihkan
                </button>
            </div>

            <!-- Cart Items List (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-4 space-y-2.5 scrollbar-thin scrollbar-thumb-slate-800 scrollbar-track-transparent">
                @forelse($cart as $index => $item)
                    <div class="flex items-center justify-between bg-slate-850/80 rounded-xl p-3.5 border border-slate-800 hover:border-slate-750 hover:bg-slate-850 transition-all duration-200 group/item">
                        <div class="flex-1 pr-3 min-w-0">
                            <h4 class="font-semibold text-slate-100 text-sm leading-tight truncate">{{ $item['name'] }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-slate-400">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </span>
                                <span class="text-slate-650">×</span>
                                <span class="text-xs font-semibold text-slate-300">{{ $item['quantity'] }}</span>
                            </div>
                            <span class="text-xs font-bold text-indigo-400 mt-0.5 block">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-1.5">
                            <button type="button"
                                    wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                    class="h-7 w-7 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-750 hover:border-slate-650 hover:text-white flex items-center justify-center font-bold text-sm focus:outline-none transition-all duration-150">−</button>

                            <input type="number"
                                   value="{{ $item['quantity'] }}"
                                   wire:change="updateQuantity({{ $index }}, $event.target.value)"
                                   class="w-10 h-7 text-center text-xs border border-slate-700 rounded-lg focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 p-0 font-semibold bg-slate-800 text-slate-100">

                            <button type="button"
                                    wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                    class="h-7 w-7 rounded-lg bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-750 hover:border-slate-650 hover:text-white flex items-center justify-center font-bold text-sm focus:outline-none transition-all duration-150">+</button>

                            <button type="button"
                                    wire:click="removeFromCart({{ $index }})"
                                    class="text-slate-500 hover:text-red-400 pl-1.5 focus:outline-none transition-colors duration-150">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center py-16 text-center">
                        <div class="bg-slate-850 rounded-2xl p-5 mb-4 ring-1 ring-slate-800/80">
                            <svg class="h-10 w-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="font-semibold text-slate-400">Keranjang kosong</span>
                        <span class="text-xs text-slate-550 mt-1.5">Klik produk untuk menambahkan</span>
                    </div>
                @endforelse
            </div>

            <!-- Calculations Summary -->
            <div class="border-t border-slate-850">
                {{-- Subtotal / Discount / Tax Section --}}
                <div class="p-5 space-y-3 bg-slate-850/50">
                    <div class="text-sm space-y-2.5">
                        <div class="flex justify-between text-slate-400">
                            <span>Subtotal</span>
                            <span class="font-medium text-slate-200 font-mono">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                        </div>

                        <!-- Discount Input -->
                        <div class="flex justify-between items-center text-slate-400">
                            <span>Diskon (%)</span>
                            <input type="number"
                                   wire:model.live="discountPercent"
                                   min="0" max="100"
                                   class="w-16 h-7 text-right text-xs border border-slate-700 rounded-lg focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 px-2 py-0 font-semibold bg-slate-850 text-slate-100">
                        </div>

                        <div class="flex justify-between text-slate-400">
                            <span>Pajak (PPN 11%)</span>
                            <span class="font-medium text-slate-200 font-mono">Rp {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Grand Total & Checkout --}}
                <div class="bg-gradient-to-br from-slate-900 via-slate-850 to-indigo-950/40 p-5 rounded-b-2xl space-y-4 border-t border-slate-800">
                    <div class="flex justify-between items-baseline">
                        <span class="font-semibold text-slate-400 text-sm uppercase tracking-wider">Grand Total</span>
                        <span class="font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-violet-300 to-purple-300 text-3xl tracking-tight font-mono">
                            Rp {{ number_format($this->total, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Checkout Action Button -->
                    <button type="button"
                            wire:click="openPaymentModal"
                            @if(empty($cart) || !$activeShiftId) disabled @endif
                            class="w-full flex items-center justify-center gap-2.5 bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 text-white font-bold py-4 rounded-xl hover:from-indigo-500 hover:via-violet-500 hover:to-purple-500 transition-all duration-300 shadow-xl shadow-indigo-500/25 hover:shadow-violet-500/35 hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-violet-400 focus:ring-offset-2 focus:ring-offset-slate-900 disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none disabled:hover:scale-100 disabled:from-slate-700 disabled:via-slate-700 disabled:to-slate-700 text-base tracking-wide">
                        @if(!$activeShiftId)
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Buka Shift Terlebih Dahulu
                        @else
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Bayar Sekarang
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Iframe for Thermal Receipt Auto-Print -->
    <iframe id="receipt-iframe" class="hidden" style="display: none; width: 0; height: 0; position: absolute;"></iframe>

    <!-- Print Event Listener Script -->
    <script>
        window.addEventListener('print-receipt', event => {
            const saleId = event.detail.saleId;
            const iframe = document.getElementById('receipt-iframe');
            if (iframe) {
                iframe.src = '/receipt/' + saleId;
            }
        });
    </script>

    <!-- ============================================== -->
    <!-- Payment Confirmation Modal                     -->
    <!-- ============================================== -->
    @if($showPaymentModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-slate-950/80 backdrop-blur-md"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="relative w-full max-w-lg mx-auto my-6 px-4">
                <div class="relative flex flex-col w-full bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl outline-none focus:outline-none overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-slate-800 bg-gradient-to-r from-slate-900 to-slate-850">
                        <div>
                            <h3 class="text-xl font-bold text-slate-100">Pembayaran</h3>
                            <p class="text-sm text-slate-400 mt-0.5">Selesaikan transaksi Anda</p>
                        </div>
                        <button wire:click="closePaymentModal" class="flex items-center justify-center h-9 w-9 rounded-xl bg-slate-800 text-slate-400 hover:bg-red-500/10 hover:text-red-400 border border-slate-700/60 hover:border-red-500/20 transition-all duration-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="relative p-6 flex-auto space-y-5">
                        <!-- Total Display — Vivid gradient banner -->
                        <div class="bg-gradient-to-br from-indigo-650 via-violet-650 to-purple-650 p-6 rounded-2xl text-center shadow-xl shadow-indigo-950/40 relative overflow-hidden">
                            {{-- Decorative radial glow --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-transparent to-white/5 rounded-2xl"></div>
                            <span class="text-xs font-bold text-indigo-200/80 uppercase tracking-widest block mb-1.5 relative">Tagihan Total</span>
                            <span class="text-4xl font-black text-white tracking-tight relative font-mono">
                                Rp {{ number_format($this->total, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Payment Method Selector -->
                        <div>
                            <label class="block text-sm font-bold text-slate-350 mb-2.5 uppercase tracking-wide">Metode Pembayaran</label>
                            <div class="grid grid-cols-3 gap-2.5">
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'cash')"
                                        class="py-3 px-4 text-sm font-semibold rounded-xl border-2 text-center transition-all duration-200 {{ $paymentMethod === 'cash' ? 'bg-gradient-to-r from-indigo-600 to-violet-600 border-indigo-500 text-white shadow-lg shadow-indigo-950/50 scale-[1.02]' : 'bg-slate-800 border-slate-750 text-slate-300 hover:bg-slate-750 hover:border-slate-600 hover:shadow-md' }}">
                                    <svg class="h-5 w-5 mx-auto mb-1.5 {{ $paymentMethod === 'cash' ? 'text-indigo-205' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Tunai
                                </button>
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'qris')"
                                        class="py-3 px-4 text-sm font-semibold rounded-xl border-2 text-center transition-all duration-200 {{ $paymentMethod === 'qris' ? 'bg-gradient-to-r from-indigo-600 to-violet-600 border-indigo-500 text-white shadow-lg shadow-indigo-950/50 scale-[1.02]' : 'bg-slate-800 border-slate-750 text-slate-300 hover:bg-slate-750 hover:border-slate-600 hover:shadow-md' }}">
                                    <svg class="h-5 w-5 mx-auto mb-1.5 {{ $paymentMethod === 'qris' ? 'text-indigo-205' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    QRIS
                                </button>
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'transfer')"
                                        class="py-3 px-4 text-sm font-semibold rounded-xl border-2 text-center transition-all duration-200 {{ $paymentMethod === 'transfer' ? 'bg-gradient-to-r from-indigo-600 to-violet-600 border-indigo-500 text-white shadow-lg shadow-indigo-950/50 scale-[1.02]' : 'bg-slate-800 border-slate-750 text-slate-300 hover:bg-slate-750 hover:border-slate-600 hover:shadow-md' }}">
                                    <svg class="h-5 w-5 mx-auto mb-1.5 {{ $paymentMethod === 'transfer' ? 'text-indigo-205' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Transfer
                                </button>
                            </div>
                        </div>

                        @if($paymentMethod === 'cash')
                            <!-- Cash Received Input -->
                            <div>
                                <label class="block text-sm font-bold text-slate-200 mb-1.5">Jumlah Uang Diterima</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-slate-400 text-sm font-bold">Rp</span>
                                    </div>
                                    <input type="number"
                                           wire:model.live="amountPaid"
                                           class="block w-full rounded-xl border-slate-700 pl-11 pr-4 py-3.5 text-lg font-bold text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 bg-slate-800 focus:bg-slate-800 transition-all duration-200 font-mono"
                                           placeholder="0"
                                           required>
                                </div>
                            </div>

                            <!-- Shortcut buttons for cash -->
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" wire:click="$set('amountPaid', {{ ceil($this->total) }})" class="py-2.5 px-2 text-xs bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white rounded-xl font-bold border border-slate-700/60 transition-all duration-200 hover:shadow-md">Uang Pas</button>
                                <button type="button" wire:click="$set('amountPaid', 10000)" class="py-2.5 px-2 text-xs bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white rounded-xl font-bold border border-slate-700/60 transition-all duration-200 hover:shadow-md">10k</button>
                                <button type="button" wire:click="$set('amountPaid', 20000)" class="py-2.5 px-2 text-xs bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white rounded-xl font-bold border border-slate-700/60 transition-all duration-200 hover:shadow-md">20k</button>
                                <button type="button" wire:click="$set('amountPaid', 50000)" class="py-2.5 px-2 text-xs bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white rounded-xl font-bold border border-slate-700/60 transition-all duration-200 hover:shadow-md">50k</button>
                                <button type="button" wire:click="$set('amountPaid', 100000)" class="py-2.5 px-2 text-xs bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white rounded-xl font-bold border border-slate-700/60 transition-all duration-200 hover:shadow-md col-span-2">100k</button>
                                <button type="button" wire:click="$set('amountPaid', {{ ceil($this->total() / 50000) * 50000 }})" class="py-2.5 px-2 text-xs bg-slate-800 hover:bg-slate-750 text-slate-300 hover:text-white rounded-xl font-bold border border-slate-700/60 transition-all duration-200 hover:shadow-md col-span-2">Bulat Keatas</button>
                            </div>

                            <!-- Change Display — Vibrant highlight -->
                            <div class="flex justify-between items-center bg-gradient-to-r from-emerald-950/65 to-teal-950/65 p-4 rounded-xl border border-emerald-900/60">
                                <span class="text-sm font-bold text-emerald-400">Kembalian:</span>
                                <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-450 to-teal-400 font-mono">
                                    Rp {{ number_format($this->changeAmount, 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div class="bg-gradient-to-r from-amber-950/45 to-orange-950/45 p-5 rounded-xl text-sm text-amber-400 border border-amber-900/50 text-center">
                                <svg class="h-8 w-8 text-amber-450 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-semibold">Silakan konfirmasi pembayaran non-tunai</span> di terminal mesin/pembaca kartu sebelum menyelesaikan transaksi.
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end p-6 border-t border-slate-850 bg-slate-900/80 space-x-3">
                        <button type="button" wire:click="closePaymentModal" class="px-5 py-2.5 text-sm font-semibold text-slate-300 bg-slate-800 border border-slate-700/60 hover:bg-slate-750 hover:shadow-sm transition-all duration-200">
                            Batal
                        </button>
                        <button type="button"
                                wire:click="checkout"
                                @if($paymentMethod === 'cash' && $amountPaid < $this->total()) disabled @endif
                                class="px-7 py-3 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 rounded-xl hover:from-indigo-500 hover:via-violet-500 hover:to-purple-500 disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-300 shadow-lg shadow-indigo-950/50 disabled:shadow-none flex items-center gap-2 hover:scale-[1.02] active:scale-[0.99]">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Selesaikan & Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
