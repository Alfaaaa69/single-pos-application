<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SinglePOS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,750&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-slate-200 bg-[#0b0f19]">
        <div class="min-h-screen flex flex-col bg-[#0b0f19]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800/80 shadow-sm text-slate-100">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 bg-[#0b0f19]">
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
        <!-- Toast / Notification Script -->
        <div x-data="{
            show: false,
            message: '',
            type: 'success',
            timeout: null,
            init() {
                window.addEventListener('notify', event => {
                    this.message = event.detail.message;
                    this.type = event.detail.type || 'success';
                    this.show = true;
                    clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => {
                        this.show = false;
                    }, 3000);
                });
            }
        }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="opacity-100 transform translate-y-0 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform translate-y-0 sm:translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-y-2 sm:translate-y-0 sm:translate-x-2"
        class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-slate-900/95 backdrop-blur-md shadow-2xl rounded-2xl pointer-events-auto border-l-4 overflow-hidden border-indigo-500 shadow-slate-950/50"
        :class="{
            'border-green-500': type === 'success',
            'border-red-500': type === 'error',
            'border-yellow-500': type === 'warning',
            'border-indigo-500': type === 'info'
        }"
        style="display: none;">
            <div class="p-4 bg-slate-900/60">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <!-- Success Heroicon -->
                        <template x-if="type === 'success'">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <!-- Error Heroicon -->
                        <template x-if="type === 'error'">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <!-- Warning Heroicon -->
                        <template x-if="type === 'warning'">
                            <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </template>
                        <!-- Info Heroicon -->
                        <template x-if="type === 'info'">
                            <svg class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-semibold text-slate-200" x-text="message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="rounded-lg inline-flex text-slate-400 hover:text-slate-200 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
