@extends('layouts.dashboard')

@section('content')
<div class="pb-24 bg-gray-50 min-h-screen">
    <!-- Dark Mode Header -->
    <div class="bg-gray-900 pt-8 pb-20 px-4 md:px-8 border-b border-gray-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiPjwvcmVjdD4KPHBhdGggZD0iTTAgMEw4IDhaTTAgOEw4IDBaIiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjA1Ij48L3BhdGg+Cjwvc3ZnPg==')] opacity-20"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Business Intelligence</h1>
                <p class="text-xs text-gray-400 font-medium mt-1 uppercase tracking-widest">Platform Overview & Live Analytics</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5 px-3 py-1.5 bg-green-500/10 border border-green-500/20 rounded-lg text-green-400 text-[10px] font-bold uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    System Online
                </span>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 p-0.5 shadow-lg">
                    <div class="w-full h-full bg-gray-900 rounded-xl flex items-center justify-center text-white font-black text-sm">
                        A
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-8 space-y-6 -mt-10 relative z-20">
        <!-- Advanced KPI Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Revenue -->
            <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-emerald-50 to-transparent"></div>
                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <span class="flex items-center text-[10px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                            12.5%
                        </span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Monthly Revenue</p>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ $stats['monthly_revenue'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Users -->
            <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-blue-50 to-transparent"></div>
                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <span class="flex items-center text-[10px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                            8.2%
                        </span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Users</p>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ number_format($stats['total_users']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Content Volume -->
            <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-purple-50 to-transparent"></div>
                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                        <span class="flex items-center text-[10px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                            4.1%
                        </span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Stories Published</p>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ number_format($stats['total_stories']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Engagement -->
            <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-pink-50 to-transparent"></div>
                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-start justify-between">
                        <div class="w-8 h-8 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h4l3-9 5 18 3-9h5"/></svg>
                        </div>
                        <span class="flex items-center text-[10px] font-black text-red-500 bg-red-50 px-1.5 py-0.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            1.2%
                        </span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Page Views</p>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ number_format($stats['total_views'] / 1000, 1) }}K</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Controls -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-900 rounded-[2rem] p-6 text-white relative overflow-hidden group cursor-pointer border border-gray-800 hover:border-indigo-500 transition-colors">
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-indigo-500/20 blur-[50px] rounded-full pointer-events-none"></div>
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-lg">Content Moderation</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1">Review flagged stories & comments</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 relative overflow-hidden group cursor-pointer hover:border-pink-300 transition-colors">
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-pink-500/10 blur-[50px] rounded-full pointer-events-none"></div>
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center border border-pink-100 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-lg text-gray-900">User Management</h3>
                        <p class="text-xs text-gray-500 font-medium mt-1">Manage roles, bans, and permissions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
