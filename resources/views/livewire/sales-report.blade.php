<div class="space-y-6">
    <!-- Filter Panel -->
    <div class="bg-white/80 backdrop-blur-md p-5 rounded-2xl shadow-sm border border-slate-200/60 ring-1 ring-slate-100/50 flex flex-col md:flex-row md:items-end justify-between gap-5">
        <div class="flex flex-wrap items-center gap-4 flex-1">
            <!-- Date From -->
            <div class="min-w-[140px]">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                <input type="date" 
                       wire:model.live="dateFrom" 
                       class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200">
            </div>

            <!-- Date To -->
            <div class="min-w-[140px]">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                <input type="date" 
                       wire:model.live="dateTo" 
                       class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200">
            </div>

            <!-- Search Invoice -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Cari Invoice</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <svg class="h-4.5 w-4.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           class="block w-full rounded-xl border-slate-200 bg-slate-50/50 pl-10 pr-4 py-2 text-sm text-slate-800 placeholder-slate-450 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200" 
                           placeholder="INV-...">
                </div>
            </div>
        </div>

        <!-- Total Revenue Widget -->
        <div class="bg-gradient-to-br from-indigo-650 to-violet-600 border border-indigo-600/20 p-5 rounded-2xl flex flex-col justify-center min-w-[220px] shadow-lg shadow-indigo-500/20 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/5 to-white/10 pointer-events-none"></div>
            <span class="text-[10px] font-extrabold text-indigo-200 uppercase tracking-widest block mb-1">Total Penjualan</span>
            <span class="text-2xl font-black text-white tracking-tight">
                Rp {{ number_format($totalSales, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- Sales Table List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">No. Invoice</th>
                        <th class="px-6 py-4">Tanggal & Waktu</th>
                        <th class="px-6 py-4">Kasir</th>
                        <th class="px-6 py-4">Metode Bayar</th>
                        <th class="px-6 py-4">Jumlah Item</th>
                        <th class="px-6 py-4">Total Belanja</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="px-6 py-4.5 font-bold text-indigo-600 font-mono text-sm">
                                {{ $sale->invoice_number }}
                            </td>
                            <td class="px-6 py-4.5 text-slate-500 font-medium">
                                {{ $sale->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4.5 font-bold text-slate-800">
                                {{ $sale->user->name }}
                            </td>
                            <td class="px-6 py-4.5 uppercase">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $sale->payment_method === 'cash' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100/50' : ($sale->payment_method === 'qris' ? 'bg-blue-50 text-blue-700 border border-blue-100/50' : 'bg-purple-50 text-purple-700 border border-purple-100/50') }}">
                                    <svg class="w-1.5 h-1.5 mr-1.5 fill-current {{ $sale->payment_method === 'cash' ? 'text-emerald-500' : ($sale->payment_method === 'qris' ? 'text-blue-500' : 'text-purple-500') }}" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                    {{ $sale->payment_method }}
                                </span>
                            </td>
                            <td class="px-6 py-4.5 font-semibold text-slate-650">
                                {{ $sale->items->sum('quantity') }} items
                            </td>
                            <td class="px-6 py-4.5 font-extrabold text-slate-850">
                                Rp {{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4.5 text-right">
                                <button type="button"
                                        onclick="printReceipt({{ $sale->id }})"
                                        class="inline-flex items-center justify-end gap-1 px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-lg text-slate-600 hover:text-indigo-650 text-xs font-bold transition-all ml-auto hover:shadow-sm">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Cetak Ulang
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium bg-slate-50/20">
                                Tidak ada transaksi penjualan tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->hasPages())
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                {{ $sales->links() }}
            </div>
        @endif
    </div>

    <!-- Hidden printing iframe specifically for reprint commands -->
    <iframe id="reprint-iframe" class="hidden" style="display: none; width: 0; height: 0; position: absolute;"></iframe>

    <script>
        function printReceipt(saleId) {
            const iframe = document.getElementById('reprint-iframe');
            if (iframe) {
                iframe.src = '/receipt/' + saleId;
            }
        }
    </script>
</div>
