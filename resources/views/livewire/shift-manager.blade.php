<div>
    <!-- Status Badge & Action Button -->
    <div class="flex items-center space-x-3 bg-slate-800 p-2.5 px-4 rounded-xl shadow-md border border-slate-700 text-slate-200">
        <div class="flex items-center space-x-2">
            <span class="h-3 w-3 rounded-full {{ $activeShift ? 'bg-emerald-500 animate-pulse shadow-md shadow-emerald-450/50' : 'bg-rose-500 shadow-md shadow-rose-450/50' }}"></span>
            <span class="text-sm font-semibold text-slate-200">
                Shift: <strong class="{{ $activeShift ? 'text-emerald-400' : 'text-rose-400' }}">{{ $activeShift ? 'Buka' : 'Tutup' }}</strong>
            </span>
            @if($activeShift)
                <span class="text-xs text-slate-400 font-medium">
                    (Saldo: Rp {{ number_format($activeShift->opening_balance, 0, ',', '.') }})
                </span>
            @endif
        </div>

        <button wire:click="openModal" class="px-3.5 py-1.5 text-xs font-bold rounded-lg shadow-md transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] {{ $activeShift ? 'bg-gradient-to-r from-rose-600 to-red-500 hover:from-rose-700 hover:to-red-655 text-white shadow-rose-950/40' : 'bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-655 text-white shadow-emerald-950/40' }}">
            {{ $activeShift ? 'Tutup Shift' : 'Mulai Shift Baru' }}
        </button>
    </div>

    <!-- Shift Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-slate-950/70 backdrop-blur-md"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="relative w-full max-w-md mx-auto my-6 px-4">
                <div class="relative flex flex-col w-full bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl outline-none focus:outline-none overflow-hidden">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-slate-800 bg-gradient-to-r from-slate-900 to-slate-850">
                        <h3 class="text-lg font-extrabold text-slate-100">
                            {{ $activeShift ? 'Tutup Shift Registrasi Kas' : 'Mulai Shift Registrasi Kas' }}
                        </h3>
                        <button wire:click="closeModal" class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-800 text-slate-400 hover:bg-red-500/10 hover:text-red-400 border border-slate-700/60 hover:border-red-500/20 transition-all duration-150">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="relative p-6 flex-auto">
                        @if($activeShift)
                            <!-- Close Shift Form -->
                            <div class="space-y-4">
                                <div class="p-4 bg-slate-850 rounded-xl border border-slate-800 text-sm text-slate-300 space-y-2.5">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-slate-400">Kasir Aktif:</span>
                                        <span class="font-bold text-slate-250">{{ auth()->user()->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-slate-400">Dibuka Pada:</span>
                                        <span class="font-bold text-slate-250">{{ $activeShift->opened_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-slate-400">Saldo Awal Kas:</span>
                                        <span class="font-bold text-slate-250 font-mono">Rp {{ number_format($activeShift->opening_balance, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-indigo-400">
                                        <span class="font-bold">Penjualan Shift:</span>
                                        <span class="font-extrabold font-mono">Rp {{ number_format($activeShift->total_sales, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-slate-800 pt-2 font-bold text-slate-200">
                                        <span>Estimasi Kas di Laci:</span>
                                        <span class="font-extrabold font-mono text-indigo-400 text-base">Rp {{ number_format($activeShift->opening_balance + $activeShift->total_sales, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-350 mb-1.5">Kas Nyata di Laci (Uang Fisik)</label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                            <span class="text-slate-400 text-sm font-bold">Rp</span>
                                        </div>
                                        <input type="number" 
                                               wire:model="closingBalance" 
                                               class="block w-full rounded-xl border-slate-700 bg-slate-800 pl-11 pr-4 py-3 text-sm text-slate-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-slate-800 transition-all duration-200 font-mono" 
                                               placeholder="0" 
                                               required>
                                    </div>
                                    @error('closingBalance') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-350 mb-1.5">Catatan Shift (Opsional)</label>
                                    <textarea wire:model="notes" 
                                              rows="3" 
                                              class="block w-full rounded-xl border-slate-700 bg-slate-800 px-4 py-3 text-sm text-slate-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-slate-800 transition-all duration-200" 
                                              placeholder="Catat selisih uang atau masalah transaksi..."></textarea>
                                    @error('notes') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @else
                            <!-- Open Shift Form -->
                            <div class="space-y-4">
                                <p class="text-sm text-slate-400 leading-relaxed">
                                    Sebelum memulai penjualan, harap input saldo modal awal yang ada di dalam laci kasir (untuk kembalian).
                                </p>

                                <div>
                                    <label class="block text-sm font-bold text-slate-350 mb-1.5">Saldo Modal Awal</label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                            <span class="text-slate-400 text-sm font-bold">Rp</span>
                                        </div>
                                        <input type="number" 
                                               wire:model="openingBalance" 
                                               class="block w-full rounded-xl border-slate-700 bg-slate-800 pl-11 pr-4 py-3 text-sm text-slate-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-slate-800 transition-all duration-200 font-mono" 
                                               placeholder="0" 
                                               required 
                                               autofocus>
                                    </div>
                                    @error('openingBalance') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end p-6 border-t border-slate-850 bg-slate-900/80 space-x-3">
                        <button wire:click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-slate-300 bg-slate-800 border border-slate-700/60 hover:bg-slate-750 transition-all duration-150">
                            Batal
                        </button>
                        @if($activeShift)
                            <button wire:click="closeShift" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-red-600 to-rose-600 rounded-xl hover:from-red-700 hover:to-rose-700 transition-all duration-200 shadow-md shadow-red-950/50 hover:scale-[1.01] active:scale-[0.99]">
                                Selesai & Tutup Shift
                            </button>
                        @else
                            <button wire:click="openShift" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-md shadow-emerald-950/50 hover:scale-[1.01] active:scale-[0.99]">
                                Buka Shift Baru
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
