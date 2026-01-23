<!DOCTYPE html>
<html lang="id" x-data="{ mobileMenu: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Inventory System' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 antialiased">

    <div class="min-h-screen flex overflow-hidden">
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl border-r border-slate-800"
            :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'">

            <div class="p-8">
                <div class="flex items-center gap-3 group cursor-default">
                    <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                        <span class="text-xl">📦</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white tracking-tight leading-none">Inventory Pro</h1>
                        <p class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-bold mt-1">v.2.0.1</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 space-y-8 scrollbar-hide">
                
                <div>
                    <p class="px-4 text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-4">Workspace</p>
                    <div class="space-y-1">
                        @php
                            $navItems = [
                                ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                                ['route' => 'products.index', 'label' => 'Inventory', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                                ['route' => 'sales.transaction', 'label' => 'Point of Sale', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                            ];
                        @endphp

                        @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="relative group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs($item['route'].'*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'hover:bg-white/5 hover:text-white' }}">
                            @if(request()->routeIs($item['route'].'*'))
                                <span class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 mr-3 {{ request()->routeIs($item['route'].'*') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ $item['label'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="px-4 text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-4">Analytics</p>
                    <div class="space-y-1">
                        <a href="{{ route('reports.sales') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white">
                            <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="text-sm font-semibold">Penjualan</span>
                        </a>
                        <a href="{{ route('reports.profit') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white">
                            <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                            <span class="text-sm font-semibold">Profit</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 mt-auto">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center font-bold text-white shadow-inner">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                            <p class="text-[10px] text-slate-500 font-medium truncate uppercase tracking-tighter">System Manager</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-rose-500/10 text-rose-500 text-xs font-bold hover:bg-rose-500 hover:text-white transition-all duration-300 tracking-widest uppercase">
                            Logout System
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button @click="mobileMenu = true" class="lg:hidden p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h2 class="hidden md:block text-sm font-semibold text-slate-500 uppercase tracking-[0.2em]">Inventory Management / <span class="text-slate-900">{{ $title ?? 'Dashboard' }}</span></h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-xs font-bold text-slate-400">{{ now()->format('l, d F Y') }}</span>
                        <span class="text-[10px] text-emerald-500 font-black tracking-widest uppercase">System Online</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-8 lg:p-12 overflow-y-auto scroll-smooth">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <div x-show="mobileMenu"
         x-cloak
         @click="mobileMenu = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden">
    </div>

    @livewireScripts
</body>
</html>