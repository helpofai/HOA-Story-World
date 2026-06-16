@extends('layouts.app')

@section('content')
<div class="pb-24 min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gray-900 pt-8 pb-16 px-4 md:px-8 border-b border-gray-800 relative overflow-hidden">
        <div class="absolute top-0 right-0 -translate-y-1/3 translate-x-1/3 w-96 h-96 bg-blue-500/20 blur-[100px] rounded-full pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">My Library</h1>
            <p class="text-xs text-gray-400 font-medium mt-1 uppercase tracking-widest">Your personal collection</p>
        </div>
    </div>

    <div class="px-4 md:px-8 -mt-8 relative z-20 max-w-7xl mx-auto">
        
        <!-- App-like Tabs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-1.5 flex items-center gap-1 mb-6 overflow-x-auto scrollbar-hide">
            <button class="flex-1 min-w-[100px] py-2 px-4 bg-gray-900 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-md transition-all">
                Reading
            </button>
            <button class="flex-1 min-w-[100px] py-2 px-4 bg-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                Bookmarks
            </button>
            <button class="flex-1 min-w-[100px] py-2 px-4 bg-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                Finished
            </button>
            <button class="flex-1 min-w-[100px] py-2 px-4 bg-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                Downloads
            </button>
        </div>

        <!-- Reading List -->
        <div class="space-y-4">
            @foreach($readingNow as $story)
            <a href="{{ route('story.reader', ['slug' => $story['slug'], 'chapterId' => $story['chapter_id']]) }}" class="bg-white p-4 rounded-[2rem] shadow-sm border border-gray-100 flex gap-5 group hover:shadow-md hover:border-blue-100 transition-all">
                <!-- Cover -->
                <div class="w-20 h-28 md:w-24 md:h-36 bg-gradient-to-br from-{{ $story['theme'] }}-900 to-{{ $story['theme'] }}-700 rounded-2xl flex-shrink-0 shadow-sm relative overflow-hidden">
                    <img src="{{ $story['cover'] }}" class="w-full h-full object-cover mix-blend-overlay opacity-80 group-hover:scale-105 transition-transform duration-500">
                </div>
                
                <!-- Content -->
                <div class="flex-1 flex flex-col justify-center py-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $story['current_chapter'] }}</span>
                        <span class="text-[10px] text-gray-400 font-medium">{{ $story['last_read'] }}</span>
                    </div>
                    
                    <h3 class="text-lg font-black text-gray-900 leading-tight mb-1 group-hover:text-blue-600 transition-colors">{{ $story['title'] }}</h3>
                    <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-4">{{ $story['author'] }}</p>
                    
                    <div class="flex items-center gap-4 mt-auto">
                        <div class="flex-1">
                            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full relative" style="width: {{ $story['progress'] }}%">
                                    <div class="absolute right-0 top-0 bottom-0 w-2 bg-white/30 rounded-full"></div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-1.5">
                                <span class="text-[10px] font-bold text-gray-400">{{ $story['progress'] }}% Completed</span>
                            </div>
                        </div>
                        <button class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M5 3l14 9-14 9V3z"/></svg>
                        </button>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
