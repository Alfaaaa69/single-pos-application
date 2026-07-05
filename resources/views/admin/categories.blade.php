<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-slate-900 leading-tight tracking-tight">
            {{ __('Kelola Kategori') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:category-manager />
        </div>
    </div>
</x-admin-layout>
