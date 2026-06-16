<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Story Platform') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 select-none bg-gray-50" x-data>
    <x-search-modal />
    <!-- Sticky Top Header -->
    <header class="fixed top-0 left-0 right-0 z-[100] w-full bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300">
            <div class="flex items-center justify-between h-14 px-4 max-w-7xl mx-auto">
                <div class="flex items-center gap-6">
                    <a href="/" class="text-2xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-pink-600">
                        Story.
                    </a>
                    
                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center gap-6 text-sm font-bold text-gray-500">
                        <a href="/" class="hover:text-gray-900 transition-colors {{ request()->is('/') ? 'text-gray-900' : '' }}">Home</a>
                        <a href="/explore" class="hover:text-gray-900 transition-colors {{ request()->is('explore*') ? 'text-gray-900' : '' }}">Explore</a>
                    </nav>
                </div>
<div class="flex items-center gap-4">
    <!-- Search Bar -->
    <div @click="$dispatch('open-search')" class="hidden sm:flex items-center bg-gray-100/60 hover:bg-gray-100 px-4 py-2 rounded-full border border-transparent focus-within:bg-white focus-within:border-blue-200 focus-within:ring-4 ring-blue-500/10 transition-all w-64 group cursor-pointer">
        <svg class="text-gray-400 group-focus-within:text-blue-500 transition-colors flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <span class="text-xs ml-2 text-gray-400 font-bold">Search...</span>
    </div>

    <!-- Mobile Search Icon -->
    <button @click="$dispatch('open-search')" class="sm:hidden p-2 text-gray-500 hover:text-gray-900 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
    </button>
                    
                    @auth
                        <!-- Profile Dropdown (Alpine) -->
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-pink-600 p-[1.5px] shadow-sm hover:scale-105 transition-transform">
                                <div class="w-full h-full bg-white rounded-full flex items-center justify-center text-gray-900 font-black text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="dropdownOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute right-0 mt-3 w-56 bg-white/90 backdrop-blur-2xl rounded-2xl shadow-2xl border border-gray-100 overflow-hidden py-2 z-50 origin-top-right" 
                                 style="display: none;">
                                
                                <div class="px-4 py-3 border-b border-gray-50 mb-1">
                                    <p class="text-sm font-black text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-0.5 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @if(Auth::user()->isAdmin())
                                    <a href="/admin" class="flex items-center gap-3 px-4 py-2.5 text-sm text-indigo-600 hover:bg-indigo-50 font-bold transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                                        Admin Studio
                                    </a>
                                @else
                                    <a href="/dashboard" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-600 font-bold transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                        My Dashboard
                                    </a>
                                @endif
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <x-animated-logout />
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-gradient-to-r from-blue-600 to-pink-600 text-white text-xs font-black tracking-widest uppercase rounded-full shadow-lg shadow-pink-500/20 hover:shadow-pink-500/40 transition-all hover:scale-105 active:scale-95">Join</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="w-full mx-auto overflow-x-hidden pt-14 pb-20 md:pb-0">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Bottom Navigation (Mobile Only) -->
        <nav class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white/90 backdrop-blur-xl border-t border-gray-100 md:hidden">
            <div class="grid h-full grid-cols-4 mx-auto font-medium">
                <a href="/" class="inline-flex flex-col items-center justify-center px-2 hover:bg-gray-50 group transition-colors {{ request()->is('/') ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 mb-1 transition-transform group-active:scale-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.47 3.84a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.06l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 0 0 1.061 1.06l8.69-8.69Z"/><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z"/></svg>
                    <span class="text-[9px] font-black uppercase tracking-wider">Home</span>
                </a>
                <a href="/explore" class="inline-flex flex-col items-center justify-center px-2 hover:bg-gray-50 group transition-colors {{ request()->is('explore*') ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 mb-1 transition-transform group-active:scale-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    <span class="text-[9px] font-black uppercase tracking-wider">Explore</span>
                </a>
                <a href="/library" class="inline-flex flex-col items-center justify-center px-2 hover:bg-gray-50 group transition-colors {{ request()->is('library*') ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 mb-1 transition-transform group-active:scale-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                    <span class="text-[9px] font-black uppercase tracking-wider">Library</span>
                </a>
                @auth
                <a href="/dashboard" class="inline-flex flex-col items-center justify-center px-2 hover:bg-gray-50 group transition-colors {{ request()->is('dashboard*') ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 mb-1 transition-transform group-active:scale-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    <span class="text-[9px] font-black uppercase tracking-wider">Profile</span>
                </a>
                @else
                <a href="/login" class="inline-flex flex-col items-center justify-center px-2 hover:bg-gray-50 group transition-colors text-gray-400">
                    <svg class="w-6 h-6 mb-1 transition-transform group-active:scale-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    <span class="text-[9px] font-black uppercase tracking-wider">Login</span>
                </a>
                @endauth
            </div>
        </nav>
</body>
</html>
