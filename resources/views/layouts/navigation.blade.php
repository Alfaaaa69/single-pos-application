<nav x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800/80 sticky top-0 z-40 shadow-lg shadow-slate-950/20">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pos') }}" class="flex items-center gap-2 group">
                        <div class="p-2 bg-indigo-600/20 border border-indigo-500/30 rounded-xl group-hover:bg-indigo-600/30 transition-colors">
                            <x-application-logo class="h-6 w-6 fill-current text-indigo-400" />
                        </div>
                        <span class="text-lg font-black tracking-wider text-white group-hover:text-indigo-200 transition-colors">SinglePOS</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                            {{ __('Dashboard') }}
                        </a>
                    @endif

                    <a href="{{ route('pos') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('pos') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                        {{ __('POS Terminal') }}
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.products') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                            {{ __('Produk') }}
                        </a>
                        <a href="{{ route('admin.categories') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                            {{ __('Kategori') }}
                        </a>
                        <a href="{{ route('admin.sales') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.sales') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                            {{ __('Laporan Penjualan') }}
                        </a>
                        <a href="{{ route('admin.shifts') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('admin.shifts') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                            {{ __('Laporan Shift') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-800 text-sm leading-4 font-semibold rounded-xl text-slate-300 bg-slate-800/80 hover:text-white hover:bg-slate-800 focus:outline-none transition-all duration-150 ring-1 ring-slate-700/30">
                            <div class="flex items-center">
                                <span class="mr-2 bg-indigo-500/25 border border-indigo-400/20 text-indigo-300 text-[10px] px-2 py-0.5 rounded-lg font-bold uppercase tracking-wider">
                                    {{ auth()->user()->role->display_name }}
                                </span>
                                <div>{{ Auth::user()->name }}</div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 font-medium">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             class="text-red-600 hover:bg-red-50 font-medium"
                                             onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition-all duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-t border-slate-800/80">
        <div class="pt-2 pb-3 space-y-1 px-3">
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="rounded-xl text-slate-300 hover:text-white">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('pos')" :active="request()->routeIs('pos')" class="rounded-xl text-slate-300 hover:text-white">
                {{ __('POS Terminal') }}
            </x-responsive-nav-link>

            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.products')" :active="request()->routeIs('admin.products')" class="rounded-xl text-slate-300 hover:text-white">
                    {{ __('Produk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories')" :active="request()->routeIs('admin.categories')" class="rounded-xl text-slate-300 hover:text-white">
                    {{ __('Kategori') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sales')" :active="request()->routeIs('admin.sales')" class="rounded-xl text-slate-300 hover:text-white">
                    {{ __('Laporan Penjualan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.shifts')" :active="request()->routeIs('admin.shifts')" class="rounded-xl text-slate-300 hover:text-white">
                    {{ __('Laporan Shift') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-800/80 bg-slate-950/20">
            <div class="px-6">
                <div class="font-bold text-base text-slate-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-3">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl text-slate-300 hover:text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="rounded-xl text-red-400 hover:text-red-300"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
