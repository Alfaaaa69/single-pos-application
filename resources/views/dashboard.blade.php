<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-slate-900 leading-tight tracking-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Sales Today -->
                @php
                    $todaySales = \App\Models\Sale::whereDate('created_at', today())->sum('total');
                    $todayCount = \App\Models\Sale::whereDate('created_at', today())->count();
                    $totalProducts = \App\Models\Product::active()->count();
                    $activeShifts = \App\Models\CashShift::open()->count();
                @endphp
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/60 flex flex-col justify-between hover:shadow-md transition-shadow duration-200 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-16 w-16 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Penjualan Hari Ini</span>
                        </div>
                        <span class="text-2xl font-black text-slate-800 mt-4 block">
                            Rp {{ number_format($todaySales, 0, ',', '.') }}
                        </span>
                    </div>
                    <span class="text-xs text-indigo-600 font-bold mt-4 block">{{ $todayCount }} transaksi hari ini</span>
                </div>

                <!-- Active Products -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/60 flex flex-col justify-between hover:shadow-md transition-shadow duration-200 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-16 w-16 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Produk Aktif</span>
                        </div>
                        <span class="text-2xl font-black text-slate-800 mt-4 block">
                            {{ $totalProducts }}
                        </span>
                    </div>
                    <a href="{{ route('admin.products') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold mt-4 inline-flex items-center gap-1 group/link">
                        Kelola Produk
                        <svg class="h-3 w-3 transition-transform group-hover/link:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Active Shifts -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/60 flex flex-col justify-between hover:shadow-md transition-shadow duration-200 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-16 w-16 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-xl">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Shift Aktif</span>
                        </div>
                        <span class="text-2xl font-black text-slate-800 mt-4 block">
                            {{ $activeShifts }}
                        </span>
                    </div>
                    <a href="{{ route('admin.shifts') }}" class="text-xs text-amber-600 hover:text-amber-700 font-bold mt-4 inline-flex items-center gap-1 group/link">
                        Log Riwayat Shift
                        <svg class="h-3 w-3 transition-transform group-hover/link:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Fast Terminal Access -->
                <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-700 p-6 rounded-2xl shadow-lg shadow-indigo-500/20 flex flex-col justify-between text-white relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/5 to-white/10 pointer-events-none"></div>
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-white/15 rounded-xl">
                                <svg class="h-5 w-5 text-indigo-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-indigo-200 uppercase tracking-wider block">Terminal POS</span>
                        </div>
                        <span class="text-xl font-extrabold mt-3.5 block leading-tight">Mulai Transaksi</span>
                    </div>
                    <a href="{{ route('pos') }}" class="bg-white text-indigo-700 font-extrabold text-xs px-4.5 py-2.5 rounded-xl hover:bg-slate-50 hover:shadow-lg active:scale-[0.98] transition-all w-fit mt-4 flex items-center gap-1.5 shadow-md shadow-indigo-950/20">
                        Buka POS Terminal
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Sales List -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200/60 p-6 space-y-5">
                    <div class="flex justify-between items-center">
                        <h3 class="font-extrabold text-slate-800 text-base">Transaksi Terakhir</h3>
                        <a href="{{ route('admin.sales') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-0.5">
                            Semua Laporan
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 text-sm">
                            <thead>
                                <tr class="text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-3">No. Invoice</th>
                                    <th class="py-3">Kasir</th>
                                    <th class="py-3">Waktu</th>
                                    <th class="py-3 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse(\App\Models\Sale::latest()->limit(5)->get() as $recentSale)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-3.5 font-bold font-mono text-indigo-600 text-sm">{{ $recentSale->invoice_number }}</td>
                                        <td class="py-3.5 text-slate-700 font-medium">{{ $recentSale->user->name }}</td>
                                        <td class="py-3.5 text-slate-400 text-xs">{{ $recentSale->created_at->diffForHumans() }}</td>
                                        <td class="py-3.5 text-right font-extrabold text-slate-800">Rp {{ number_format($recentSale->total, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-450 font-medium">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Admin Navigation -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 p-6 space-y-4">
                    <h3 class="font-extrabold text-slate-800 text-base">Menu Navigasi Cepat</h3>
                    <div class="grid grid-cols-1 gap-2.5">
                        <a href="{{ route('admin.products') }}" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:bg-indigo-50/30 hover:border-indigo-200/50 hover:text-indigo-700 transition-all duration-200 group/nav">
                            <span class="text-sm font-bold text-slate-700 group-hover/nav:text-indigo-700">Kelola Produk</span>
                            <svg class="h-4 w-4 text-slate-400 group-hover/nav:text-indigo-600 transition-transform group-hover/nav:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.categories') }}" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:bg-indigo-50/30 hover:border-indigo-200/50 hover:text-indigo-700 transition-all duration-200 group/nav">
                            <span class="text-sm font-bold text-slate-700 group-hover/nav:text-indigo-700">Kelola Kategori</span>
                            <svg class="h-4 w-4 text-slate-400 group-hover/nav:text-indigo-600 transition-transform group-hover/nav:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.users') }}" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:bg-indigo-50/30 hover:border-indigo-200/50 hover:text-indigo-700 transition-all duration-200 group/nav">
                            <span class="text-sm font-bold text-slate-700 group-hover/nav:text-indigo-700">Kelola Pengguna / Karyawan</span>
                            <svg class="h-4 w-4 text-slate-400 group-hover/nav:text-indigo-600 transition-transform group-hover/nav:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.sales') }}" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:bg-indigo-50/30 hover:border-indigo-200/50 hover:text-indigo-700 transition-all duration-200 group/nav">
                            <span class="text-sm font-bold text-slate-700 group-hover/nav:text-indigo-700">Laporan Penjualan</span>
                            <svg class="h-4 w-4 text-slate-400 group-hover/nav:text-indigo-600 transition-transform group-hover/nav:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.shifts') }}" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 hover:bg-indigo-50/30 hover:border-indigo-200/50 hover:text-indigo-700 transition-all duration-200 group/nav">
                            <span class="text-sm font-bold text-slate-700 group-hover/nav:text-indigo-700">Riwayat Shift</span>
                            <svg class="h-4 w-4 text-slate-400 group-hover/nav:text-indigo-600 transition-transform group-hover/nav:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
