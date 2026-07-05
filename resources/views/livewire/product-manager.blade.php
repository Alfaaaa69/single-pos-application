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
                   placeholder="Cari nama, SKU, atau barcode...">
        </div>

        <!-- Add Button -->
        <button type="button"
                wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl hover:from-indigo-700 hover:to-violet-700 shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/35 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Produk Baru
        </button>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4">SKU / Barcode</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-11 w-11 flex-shrink-0 bg-slate-50 rounded-xl overflow-hidden border border-slate-200 mr-3.5 flex items-center justify-center shadow-sm">
                                        @if($product->image)
                                            <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @else
                                            <svg class="h-6 w-6 text-slate-350" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-sm leading-tight">{{ $product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-bold font-mono bg-slate-100 text-slate-650 px-2 py-0.5 rounded-lg border border-slate-200/50 block w-fit mb-1 tracking-wide">SKU: {{ $product->sku }}</span>
                                @if($product->barcode)
                                    <span class="text-[10px] font-bold font-mono text-slate-400 block tracking-wide">BC: {{ $product->barcode }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center text-[10px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-100/50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-extrabold text-slate-800">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($product->stock <= 5)
                                    <span class="font-bold text-amber-600 bg-amber-50 border border-amber-150 px-2 py-0.5 rounded-lg text-xs">
                                        {{ $product->stock }} (Tipis)
                                    </span>
                                @else
                                    <span class="font-extrabold text-slate-700 text-sm">
                                        {{ $product->stock }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $product->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                    <svg class="w-1.5 h-1.5 mr-1.5 fill-current {{ $product->is_active ? 'text-emerald-500' : 'text-red-500' }}" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <button wire:click="openEditModal({{ $product->id }})" class="text-indigo-600 hover:text-indigo-850 font-bold hover:underline transition-colors">Edit</button>
                                @if($product->is_active)
                                    <button wire:click="delete({{ $product->id }})" wire:confirm="Nonaktifkan produk ini?" class="text-red-650 hover:text-red-805 font-bold hover:underline transition-colors">Nonaktifkan</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium bg-slate-50/20">
                                Tidak ada produk terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Product Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-slate-950/60 backdrop-blur-sm"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="relative w-full max-w-lg mx-auto my-6 px-4">
                <form wire:submit="save" class="relative flex flex-col w-full bg-white border-0 rounded-2xl shadow-2xl outline-none focus:outline-none overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-gradient-to-r from-white to-slate-50/80">
                        <h3 class="text-lg font-extrabold text-slate-900">
                            {{ $isEditing ? 'Ubah Produk' : 'Tambah Produk Baru' }}
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
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Produk</label>
                            <input type="text" 
                                   wire:model="name" 
                                   class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200" 
                                   required>
                            @error('name') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Upload & Preview -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Foto Produk (Maks 2MB)</label>
                            
                            <div class="mt-1 flex items-center space-x-4">
                                <div class="h-16 w-16 bg-slate-50 rounded-xl overflow-hidden border border-slate-200 flex items-center justify-center flex-shrink-0 shadow-inner">
                                    @if($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="h-full w-full object-contain">
                                    @elseif($existingImage)
                                        <img src="{{ asset('products/' . $existingImage) }}" class="h-full w-full object-contain">
                                    @else
                                        <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" 
                                           wire:model="image" 
                                           class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border file:border-slate-200 file:text-xs file:font-bold file:bg-white file:text-indigo-600 hover:file:bg-indigo-50 file:cursor-pointer transition-all duration-150">
                                    <div wire:loading wire:target="image" class="text-xs text-indigo-650 mt-1.5 font-bold animate-pulse">Mengunggah...</div>
                                    @error('image') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- SKU -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">SKU (Kode Unik)</label>
                                <input type="text" 
                                       wire:model="sku" 
                                       class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200" 
                                       required>
                                @error('sku') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Barcode -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Barcode (Opsional)</label>
                                <input type="text" 
                                       wire:model="barcode" 
                                       class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200">
                                @error('barcode') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Kategori</label>
                                <select wire:model="categoryId" 
                                        class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200 cursor-pointer" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('categoryId') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Harga Jual (Rp)</label>
                                <input type="number" 
                                       wire:model="price" 
                                       class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200" 
                                       min="0" 
                                       required>
                                @error('price') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Stock -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Stok Awal</label>
                                <input type="number" 
                                       wire:model="stock" 
                                       class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 focus:bg-white transition-all duration-200" 
                                       min="0" 
                                       required>
                                @error('stock') <span class="text-xs text-red-500 mt-1.5 font-semibold block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Is Active Status -->
                            <div class="flex items-center mt-7">
                                <input type="checkbox" 
                                       wire:model="isActive" 
                                       id="isActive" 
                                       class="h-4.5 w-4.5 rounded-md border-slate-350 text-indigo-655 focus:ring-2 focus:ring-indigo-500/25 cursor-pointer">
                                <label for="isActive" class="ml-2.5 block text-sm font-bold text-slate-700 cursor-pointer">Produk Aktif</label>
                            </div>
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
