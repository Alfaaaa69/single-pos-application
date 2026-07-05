<x-app-layout>
    <div class="py-6 bg-[#0b0f19] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-100 tracking-tight">POS Terminal</h1>
                    <p class="text-sm text-slate-400 mt-0.5">Kelola transaksi penjualan Anda</p>
                </div>
                <!-- Shift Manager Component -->
                <livewire:shift-manager />
            </div>

            <!-- Main POS Terminal Component -->
            <livewire:pos-terminal />
        </div>
    </div>
</x-app-layout>
