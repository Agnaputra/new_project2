<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Inventory System' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white hidden lg:block">
            <div class="p-6">
                <h1 class="text-2xl font-bold">📦 Inventory Pro</h1>
                <p class="text-blue-200 text-sm mt-1">Sistem Manajemen Stok</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-blue-700 border-r-4 border-white' : 'hover:bg-blue-700' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('products.index') }}" 
                   class="flex items-center px-6 py-3 {{ request()->routeIs('products.*') ? 'bg-blue-700 border-r-4 border-white' : 'hover:bg-blue-700' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Data Produk
                </a>
                
                <a href="{{ route('sales.transaction') }}" 
                   class="flex items-center px-6 py-3 {{ request()->routeIs('sales.*') ? 'bg-blue-700 border-r-4 border-white' : 'hover:bg-blue-700' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Transaksi Penjualan
                </a>

                <div class="px-6 py-3 mt-6">
                    <p class="text-xs text-blue-300 uppercase font-semibold mb-3">Laporan</p>
                </div>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Laporan Penjualan
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    Laporan Profit
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-6 bg-blue-900">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center">
                        <span class="text-lg font-bold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-sm">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-blue-200 hover:text-white">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Menu Toggle -->
        <div class="lg:hidden fixed top-0 left-0 right-0 bg-blue-600 text-white p-4 flex justify-between items-center z-50">
            <h1 class="text-xl font-bold">📦 Inventory Pro</h1>
            <button id="mobile-menu-btn" class="p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Main Content -->
        <main class="flex-1 lg:mt-0 mt-16">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm px-6 py-4 hidden lg:flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h2>
                    <p class="text-sm text-gray-500">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->email ?? '' }}</span>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    
    <script>
        // Mobile menu toggle (optional)
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            // Add mobile menu functionality here
            alert('Mobile menu - Coming soon!');
        });
    </script>
</body>
</html>