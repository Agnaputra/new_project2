<aside 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-xl"
    :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'">
    
    <div class="p-6 bg-slate-950 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white flex items-center gap-2">
                <span class="text-2xl">📦</span> Inventory Pro
            </h1>
            <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold mt-1">Management System</p>
        </div>
        <button @click="mobileMenu = false" class="lg:hidden text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    
    <nav class="mt-4 flex-1 overflow-y-auto px-4 space-y-1">
        <div class="pb-2">
            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest px-3 mb-2">Main Menu</p>
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
        </div>
        
        <div class="pb-2">
            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest px-3 mb-2">Inventory</p>
            <a href="{{ route('products.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('products.*') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span class="text-sm font-medium">Data Produk</span>
            </a>
        </div>

        <div class="pb-2">
            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest px-3 mb-2">Sales</p>
            <a href="{{ route('sales.transaction') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('sales.transaction') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('sales.transaction') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="text-sm font-medium">Transaksi</span>
            </a>
        </div>

<div class="pb-2">
    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest px-3 mb-2">Reports</p>
    <a href="{{ route('reports.sales') }}" 
       class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('reports.sales') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'hover:bg-slate-800 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.sales') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        <span class="text-sm font-medium">Laporan Penjualan</span>
    </a>
    <a href="{{ route('reports.profit') }}" 
       class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('reports.profit') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'hover:bg-slate-800 hover:text-white' }}">
        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.profit') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
        <span class="text-sm font-medium">Laporan Profit</span>
    </a>
</div>


    <div class="p-4 bg-slate-950 border-t border-slate-800">
        <div class="flex items-center p-2 rounded-xl bg-slate-900 border border-slate-800">
            <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shadow-inner hover:bg-indigo-500 transition">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </a>
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[10px] text-rose-400 hover:text-rose-300 font-bold uppercase transition">Logout</button>
                </form>
            </div>
        </div>
    </div>
</aside>