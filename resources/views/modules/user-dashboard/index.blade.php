@extends('layouts.dashboard')

@section('content')
<div class="pb-24">
    <!-- Premium Greeting Header -->
    <div class="relative bg-gray-900 rounded-b-[2.5rem] pt-12 pb-16 px-4 md:px-8 overflow-hidden shadow-2xl">
        <!-- Decorative Mesh -->
        <div class="absolute top-0 right-0 -translate-y-1/3 translate-x-1/3 w-96 h-96 bg-blue-500/30 blur-[100px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-80 h-80 bg-pink-500/20 blur-[100px] rounded-full pointer-events-none"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-blue-400 to-pink-500 p-0.5 shadow-lg">
                        <div class="w-full h-full bg-gray-900 rounded-full flex items-center justify-center text-white text-xl font-black">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gray-800 rounded-full flex items-center justify-center border-2 border-gray-900">
                        <span class="text-[10px]">👑</span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Hi, {{ explode(' ', Auth::user()->name)[0] }}</h1>
                    <p class="text-xs md:text-sm text-gray-400 font-medium mt-1 uppercase tracking-widest flex items-center gap-2">
                        <span>Level 34</span>
                        <span class="w-1 h-1 bg-gray-600 rounded-full"></span>
                        <span class="text-blue-400">Legend Reader</span>
                    </p>
                </div>
            </div>
            <button class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
        </div>
    </div>

    <div class="px-4 md:px-8 space-y-8 -mt-8 relative z-20">
        <!-- Smart Resume / Continue Reading Widget -->
        @if($recentReading)
        <a href="{{ route('story.reader', ['slug' => $recentReading->story->slug, 'chapterId' => $recentReading->chapter_id]) }}" class="bg-white/80 backdrop-blur-2xl p-4 md:p-6 rounded-[2rem] shadow-xl border border-white flex gap-5 md:gap-6 group hover:shadow-2xl transition-all cursor-pointer">
            <div class="w-24 h-32 md:w-28 md:h-40 bg-gray-100 rounded-2xl flex-shrink-0 shadow-md border border-gray-200/50 relative overflow-hidden">
                @if($recentReading->story->cover_image)
                    <img src="{{ $recentReading->story->cover_image }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 to-purple-900 flex items-center justify-center text-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                @endif
            </div>
            <div class="flex-1 flex flex-col justify-center py-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[9px] font-black uppercase tracking-widest rounded-md">Reading Now</span>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $recentReading->chapter->title }}</span>
                </div>
                <h2 class="text-lg md:text-xl font-black text-gray-900 leading-tight mb-1 group-hover:text-blue-600 transition-colors">{{ $recentReading->story->title }}</h2>
                <p class="text-xs text-gray-500 font-medium mb-4 line-clamp-1">{{ Str::limit(strip_tags($recentReading->chapter->content), 80) }}</p>
                
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full relative" style="width: {{ $recentReading->progress_percent }}%">
                                <div class="absolute right-0 top-0 bottom-0 w-2 bg-white/30 rounded-full"></div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-1.5">
                            <span class="text-[10px] font-bold text-gray-400">{{ round($recentReading->progress_percent) }}% Completed</span>
                            <span class="text-[10px] font-bold text-blue-600">Resume</span>
                        </div>
                    </div>
                    <button class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center text-white shadow-md hover:scale-110 active:scale-95 transition-transform flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M5 3l14 9-14 9V3z"/></svg>
                    </button>
                </div>
            </div>
        </a>
        @endif

        <!-- Premium Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Streak -->
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-orange-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-orange-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-lg">🔥</span>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Current Streak</h3>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <p class="text-3xl font-black text-gray-900 tracking-tighter">{{ $stats['reading_streak'] }}</p>
                        <p class="text-xs font-bold text-gray-500 uppercase">Days</p>
                    </div>
                </div>
            </div>

            <!-- Time -->
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-blue-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-lg">⏱️</span>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Today's Time</h3>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <p class="text-3xl font-black text-gray-900 tracking-tighter">{{ $stats['daily_reading_time'] }}</p>
                        <p class="text-xs font-bold text-gray-500 uppercase">Min</p>
                    </div>
                </div>
            </div>

            <!-- Books Finished -->
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-green-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-green-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-lg">📚</span>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Completed</h3>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <p class="text-3xl font-black text-gray-900 tracking-tighter">{{ $stats['finished_stories'] }}</p>
                        <p class="text-xs font-bold text-gray-500 uppercase">Stories</p>
                    </div>
                </div>
            </div>

            <!-- Reading Speed -->
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-purple-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-lg">⚡</span>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Avg Speed</h3>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <p class="text-3xl font-black text-gray-900 tracking-tighter">245</p>
                        <p class="text-xs font-bold text-gray-500 uppercase">WPM</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reading Activity Heatmap -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 overflow-hidden">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-gray-900 tracking-tight">Reading Activity</h3>
                <span class="px-3 py-1 bg-gray-100 rounded-lg text-[10px] font-bold text-gray-600 uppercase tracking-widest">Last 40 Days</span>
            </div>
            <div class="flex gap-1.5 overflow-x-auto pb-2 scrollbar-hide">
                @foreach(array_chunk($heatmap, 4, true) as $column)
                    <div class="flex flex-col gap-1.5">
                        @foreach($column as $date => $intensity)
                            <div class="w-4 h-4 rounded-[4px] 
                                {{ $intensity === 0 ? 'bg-gray-100' : '' }}
                                {{ $intensity === 1 ? 'bg-blue-200' : '' }}
                                {{ $intensity === 2 ? 'bg-blue-400' : '' }}
                                {{ $intensity === 3 ? 'bg-blue-600' : '' }}
                                {{ $intensity === 4 ? 'bg-blue-800' : '' }}
                                transition-colors duration-300 hover:ring-2 hover:ring-gray-300 cursor-pointer"
                                title="{{ $date }}: {{ $intensity }} level activity">
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="flex items-center justify-end gap-2 mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                <span>Less</span>
                <div class="w-3 h-3 rounded-[3px] bg-gray-100"></div>
                <div class="w-3 h-3 rounded-[3px] bg-blue-200"></div>
                <div class="w-3 h-3 rounded-[3px] bg-blue-400"></div>
                <div class="w-3 h-3 rounded-[3px] bg-blue-600"></div>
                <div class="w-3 h-3 rounded-[3px] bg-blue-800"></div>
                <span>More</span>
            </div>
        </div>
        
        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="flex justify-center pt-4">
            @csrf
            <x-animated-logout />
        </form>
    </div>
</div>
@endsection