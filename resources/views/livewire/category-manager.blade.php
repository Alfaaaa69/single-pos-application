<div class="space-y-6">
    <!-- Action Panel -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/80 backdrop-blur-md p-5 rounded-2xl shadow-sm border border-slate-200/60 ring-1 ring-slate-100/50">
        <!-- Search bar -->
        <div class="w-full sm:max-w-xs relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <svg class="h-4.5 w-4.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   class="block w-full rounded-xl border-slate-200 bg-slate-50/50 pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200"
                   placeholder="Cari kategori...">
        </div>

        <!-- Add Button -->
        <button type="button"
                wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl hover:from-indigo-700 hover:to-violet-700 shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/35 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kategori Baru
        </button>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="px-6 py-4.5">
                                <div class="font-bold text-slate-800 text-base">{{ $category->name }}</div>
                            </td>
                            <td class="px-6 py-4.5 font-mono text-xs text-slate-400 font-medium">
                                {{ $category->slug }}
                            </td>
                            <td class="px-6 py-4.5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $category->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                    <svg class="w-1.5 h-1.5 mr-1.5 fill-current {{ $category->is_active ? 'text-emerald-500' : 'text-red-500' }}" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4.5 text-right space-x-3">
                                <button wire:click="openEditModal({{ $category->id }})" class="text-indigo-600 hover:text-indigo-850 font-bold hover:underline transition-colors">Edit</button>
                                @if($category->is_active)
                                    <button wire:click="delete({{ $category->id }})" wire:confirm="Nonaktifkan kategori ini?" class="text-red-650 hover:text-red-805 font-bold hover:underline transition-colors">Nonaktifkan</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium bg-slate-50/20">
                                Tidak ada kategori terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categories->hasPages())
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Category Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-slate-950/60 backdrop-blur-sm"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="relative w-full max-w-md mx-auto my-6 px-4">
                <form wire:submit="save" class="relative flex flex-col w-full bg-white border-0 rounded-2xl shadow-2xl outline-none focus:outline-none overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-gradient-to-r from-white to-slate-50/80">
                        <h3 class="text-lg font-extrabold text-slate-900">
                            {{ $isEditing ? 'Ubah Kategori' : 'Tambah Kategori Baru' }}
                        </h3>
                        <button type="button" wire:click="closeModal" class="flex items-center justify-center h-8 w-8 rounded-lg bg-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all duration-150 ring-1 ring-slate-200/50 hover:ring-red-200/50">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="relative p-6 flex-auto space-y-5">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Kategori</label>
                            <input type="text" 
                                   wire:model="name" 
                                   class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200" 
                                   required 
                                   autofocus>
                            @error('name') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="isActive" 
                                   id="isActive" 
                                   class="h-4.5 w-4.5 rounded-md border-slate-350 text-indigo-650 focus:ring-2 focus:ring-indigo-500/25 cursor-pointer">
                            <label for="isActive" class="ml-2.5 block text-sm font-bold text-slate-700 cursor-pointer">Kategori Aktif</label>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end p-6 border-t border-slate-100 bg-slate-50/50 space-x-3">
                        <button type="button" wire:click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-slate-300 transition-all duration-150">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl hover:from-indigo-700 hover:to-violet-700 transition-all duration-200 shadow-md shadow-indigo-200/40 hover:scale-[1.01] active:scale-[0.99]">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
