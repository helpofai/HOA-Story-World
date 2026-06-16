@extends('layouts.app')

@section('content')
<div class="min-h-screen pb-24 pt-10 px-4 md:px-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter mb-2">My Stories</h1>
                <p class="text-gray-500 font-medium italic">"Every secret of a writer's soul, every experience of his life, every quality of his mind, is written large in his works."</p>
            </div>
            <a href="{{ route('author.story.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-gray-900/20 hover:scale-105 active:scale-95 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                New Story
            </a>
        </div>

        @if($stories->count() > 0)
        <!-- Works Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($stories as $story)
            <div class="group bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col">
                <!-- Cover Section -->
                <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                    @if($story->cover_image)
                        <img src="{{ $story->cover_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-50 to-pink-50 flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                    @endif
                    
                    <!-- Floating Stats -->
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-full text-[9px] font-black text-white uppercase tracking-widest border border-white/10">
                            {{ ucfirst($story->status) }}
                        </span>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                        <a href="{{ route('author.studio', ['story_id' => $story->id]) }}" class="p-4 bg-white rounded-full text-gray-900 shadow-xl hover:scale-110 transition-transform" title="Write Now">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">{{ $story->age_rating }} Rating</span>
                        <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $story->chapters_count }} Chapters</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 leading-tight mb-2 truncate group-hover:text-blue-600 transition-colors">{{ $story->title }}</h3>
                    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed mb-6">{{ $story->synopsis }}</p>

                    <!-- Footer -->
                    <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Last Edited</span>
                            <span class="text-xs font-bold text-gray-600">{{ $story->updated_at->diffForHumans() }}</span>
                        </div>
                        <a href="{{ route('author.studio', ['story_id' => $story->id]) }}" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                            Go to Studio
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-[3rem] border-4 border-dashed border-gray-100 p-20 text-center">
            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">The canvas is blank...</h3>
            <p class="text-gray-500 font-medium mb-8">You haven't created any story universes yet. Let's change that.</p>
            <a href="{{ route('author.story.create') }}" class="inline-block px-10 py-4 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-600/20 hover:scale-105 active:scale-95 transition-all">
                Create First Story
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
