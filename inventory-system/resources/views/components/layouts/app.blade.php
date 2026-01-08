<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Inventory Pro') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900" x-data="{ mobileMenu: false }">
    <div class="min-h-screen flex flex-col lg:flex-row">
        
        @include('layouts.navigation')

        <div class="flex-1 flex flex-col min-w-0 bg-slate-50">
            
            <header class="lg:hidden bg-slate-900 text-white p-4 flex justify-between items-center sticky top-0 z-40 shadow-lg">
                <h1 class="text-lg font-bold flex items-center gap-2">📦 <span class="tracking-tight">Inventory Pro</span></h1>
                <button @click="mobileMenu = true" class="p-2 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 active:scale-95 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </header>

            <header class="bg-white border-b border-slate-200 px-8 py-4 hidden lg:flex justify-between items-center sticky top-0 z-30 shadow-sm">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800 tracking-tight uppercase">{{ $header ?? 'Dashboard Overview' }}</h2>
                    <p class="text-[10px] text-slate-400 font-bold flex items-center gap-1 uppercase">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-bold text-slate-700">{{ auth()->user()->email }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-tighter">● Online</span>
                    </div>
                </div>
            </header>

            <main class="p-4 lg:p-8 flex-1">
                <div x-show="mobileMenu" @click="mobileMenu = false" class="lg:hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 transition-opacity"></div>
                
                <div class="max-w-7xl mx-auto space-y-4">
                    @if (session('success'))
                        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm flex items-center animate-fade-in-down">
                            <div class="p-1 bg-emerald-500 rounded-full mr-3 text-white">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-sm font-bold tracking-tight">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="animate-fade-in">
                        {{ $slot }}
                    </div>
                </div>
            </main>
            
            <footer class="bg-white border-t border-slate-200 px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">&copy; {{ date('Y') }} Inventory Pro System <span class="text-indigo-400">●</span> Premium Edition</p>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">v1.0.4 stable</span>
            </footer>
        </div>
    </div>

    @livewireScripts
</body>
</html>