<div class="space-y-6">
    <!-- Filter Panel -->
    <div class="bg-white/80 backdrop-blur-md p-5 rounded-2xl shadow-sm border border-slate-200/60 ring-1 ring-slate-100/50 flex flex-wrap items-center gap-4">
        <!-- Date From -->
        <div class="min-w-[150px]">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
            <input type="date" 
                   wire:model.live="dateFrom" 
                   class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200">
        </div>

        <!-- Date To -->
        <div class="min-w-[150px]">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
            <input type="date" 
                   wire:model.live="dateTo" 
                   class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200">
        </div>
    </div>

    <!-- Shifts Table List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Kasir</th>
                        <th class="px-6 py-4">Waktu Buka</th>
                        <th class="px-6 py-4">Waktu Tutup</th>
                        <th class="px-6 py-4">Saldo Awal</th>
                        <th class="px-6 py-4">Total Penjualan</th>
                        <th class="px-6 py-4">Saldo Akhir</th>
                        <th class="px-6 py-4">Selisih</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($shifts as $shift)
                        @php
                            $expectedBalance = $shift->opening_balance + $shift->total_sales;
                            $difference = $shift->status === 'closed' ? ($shift->closing_balance - $expectedBalance) : null;
                        @endphp
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="px-6 py-4.5 font-bold text-slate-800">
                                {{ $shift->user->name }}
                            </td>
                            <td class="px-6 py-4.5 text-slate-500 font-medium">
                                {{ $shift->opened_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4.5 text-slate-500 font-medium">
                                {{ $shift->closed_at ? $shift->closed_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4.5 font-mono text-xs text-slate-600 font-bold">
                                Rp {{ number_format($shift->opening_balance, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4.5 font-bold text-indigo-650 font-mono text-xs">
                                Rp {{ number_format($shift->total_sales, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4.5 font-mono text-xs text-slate-600 font-bold">
                                {{ $shift->closing_balance ? 'Rp '.number_format($shift->closing_balance, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4.5">
                                @if($difference !== null)
                                    @if($difference == 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/50">Sesuai</span>
                                    @elseif($difference > 0)
                                        <span class="text-emerald-750 font-black font-mono text-xs">
                                            +Rp {{ number_format($difference, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-red-650 font-black font-mono text-xs">
                                            Rp {{ number_format($difference, 0, ',', '.') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-slate-400 font-medium">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $shift->status === 'open' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 animate-pulse' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    @if($shift->status === 'open')
                                        <svg class="w-1.5 h-1.5 mr-1.5 fill-current text-emerald-500" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                    @endif
                                    {{ $shift->status === 'open' ? 'Aktif' : 'Selesai' }}
                                </span>
                            </td>
                            <td class="px-6 py-4.5 text-slate-400 font-medium max-w-xs truncate text-xs" title="{{ $shift->notes }}">
                                {{ $shift->notes ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-400 font-medium bg-slate-50/20">
                                Tidak ada log shift terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($shifts->hasPages())
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                {{ $shifts->links() }}
            </div>
        @endif
    </div>
</div>
