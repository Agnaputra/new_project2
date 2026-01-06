<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Inventory Pro') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white hidden lg:flex flex-col sticky top-0 h-screen shadow-2xl">
            <div class="p-6">
                <h1 class="text-2xl font-bold">📦 Inventory Pro</h1>
                <p class="text-blue-100 text-xs mt-1">Manajemen Stok & Penjualan</p>
            </div>
            
            <nav class="mt-4 flex-1 overflow-y-auto px-4 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-blue-700 shadow-inner' : 'hover:bg-blue-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('products.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('products.*') ? 'bg-blue-700 shadow-inner' : 'hover:bg-blue-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Data Produk
                </a>
                
                <a href="{{ route('sales.transaction') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('sales.transaction') ? 'bg-blue-700 shadow-inner' : 'hover:bg-blue-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Transaksi Penjualan
                </a>

                <div class="pt-4 pb-2">
                    <p class="text-[10px] text-blue-300 uppercase font-bold tracking-widest px-4">Laporan</p>
                </div>
                
                <a href="{{ route('reports.sales') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('reports.sales') ? 'bg-blue-700 shadow-inner' : 'hover:bg-blue-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Laporan Penjualan
                </a>
                
                <a href="{{ route('reports.profit') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('reports.profit') ? 'bg-blue-700 shadow-inner' : 'hover:bg-blue-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    Laporan Profit
                </a>
            </nav>

            <div class="p-4 bg-blue-900 border-t border-blue-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center font-bold text-white border border-blue-400">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-[10px] text-blue-300 hover:text-white underline uppercase font-bold tracking-tighter">Keluar Sistem</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <header class="lg:hidden bg-blue-600 text-white p-4 flex justify-between items-center sticky top-0 z-50 shadow-md">
            <h1 class="text-lg font-bold uppercase tracking-tight">📦 Inventory Pro</h1>
            <button onclick="document.getElementById('mobile-sidebar').classList.toggle('-translate-x-full')" class="p-2 hover:bg-blue-500 rounded-md transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </header>

        <main class="flex-1 min-w-0 flex flex-col">
            
            <div class="bg-white shadow-sm px-8 py-4 hidden lg:flex justify-between items-center border-b border-gray-200">
                <div>
                    <h2 class="text-xl font-extrabold text-gray-800 tracking-tight uppercase">{{ $header ?? 'Beranda Utama' }}</h2>
                    <p class="text-xs text-gray-400 font-medium">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-700">{{ auth()->user()->email ?? '' }}</p>
                        <p class="text-[10px] text-green-500 font-bold uppercase">Sesi Aktif</p>
                    </div>
                </div>
            </div>

            <div class="p-4 lg:p-8 flex-1 overflow-auto">
                
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-lg shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </div>
            
            <footer class="bg-white border-t border-gray-200 px-8 py-3 text-center lg:text-left">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">&copy; {{ date('Y') }} Inventory Pro System v1.0.4</p>
            </footer>
        </main>
    </div>

    @livewireScripts
</body>
</html>