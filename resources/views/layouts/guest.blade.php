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
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-950">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-950 via-slate-900 to-zinc-950 relative overflow-hidden">
            <!-- Background Decorative Glows -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-indigo-500/10 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-purple-500/10 blur-[120px] pointer-events-none"></div>

            <div class="z-10 w-full flex flex-col items-center">
                <div class="mb-8 transition-transform duration-300 hover:scale-105">
                    <a href="/" class="flex flex-col items-center gap-2 group">
                        <div class="p-3.5 bg-indigo-600/15 border border-indigo-500/30 rounded-2xl shadow-xl shadow-indigo-950/40 group-hover:border-indigo-400/50 group-hover:bg-indigo-600/20 transition-all duration-300">
                            <x-application-logo class="w-12 h-12 fill-current text-indigo-400 group-hover:text-indigo-300 transition-colors" />
                        </div>
                        <span class="text-2xl font-black tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 via-violet-200 to-purple-200 uppercase mt-2">SinglePOS</span>
                    </a>
                </div>

                <div class="w-full sm:max-w-md bg-white/85 backdrop-blur-xl border border-white/20 shadow-2xl rounded-3xl p-8 relative">
                    <!-- Glass glare effect -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/5 to-white/10 rounded-3xl pointer-events-none"></div>
                    
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
