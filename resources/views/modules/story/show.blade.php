@extends('layouts.app')

@section('content')
<div class="pb-24 bg-gray-50 min-h-screen">
    
    <!-- Hero Cover Section -->
    <div class="relative w-full h-[60vh] md:h-[70vh] bg-gray-900 overflow-hidden group">
        <!-- Background Blur -->
        <div class="absolute inset-0">
            @if($story->cover_image)
                <img src="{{ $story->cover_image }}" class="w-full h-full object-cover opacity-40 blur-2xl scale-110">
            @else
                <div class="w-full h-full bg-gradient-to-br from-indigo-900 via-purple-900 to-black opacity-80"></div>
            @endif
        </div>
        
        <!-- Bottom Gradient Fade to Content -->
        <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-gray-50 via-gray-50/80 to-transparent z-10"></div>

        <!-- Main Content Area inside Hero -->
        <div class="absolute inset-0 z-20 flex flex-col justify-end px-4 md:px-8 max-w-5xl mx-auto pb-8 md:pb-12">
            <div class="flex flex-col md:flex-row gap-6 md:gap-10 items-center md:items-end">
                
                <!-- Book Cover (Interactive) -->
                <div class="w-48 h-72 md:w-64 md:h-96 flex-shrink-0 rounded-2xl shadow-2xl overflow-hidden border border-white/10 transform transition-transform duration-500 hover:scale-105 hover:-translate-y-2 group-hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                    @if($story->cover_image)
                        <img src="{{ $story->cover_image }}" alt="{{ $story->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center p-6 text-center">
                            <span class="font-black text-white/50 text-2xl leading-tight">{{ $story->title }}</span>
                        </div>
                    @endif
                    <!-- Premium Glass Tag -->
                    <div class="absolute top-3 left-3 px-2.5 py-1 bg-black/40 backdrop-blur-md border border-white/20 rounded-lg flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full {{ $story->status === 'ongoing' ? 'bg-green-400 animate-pulse' : 'bg-blue-400' }}"></span>
                        <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ $story->status }}</span>
                    </div>
                </div>

                <!-- Title & Meta -->
                <div class="flex-1 text-center md:text-left text-gray-900 mt-4 md:mt-0">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-3">
                        @foreach($story->genres->take(3) as $genre)
                            <span class="px-2.5 py-1 bg-white/60 backdrop-blur-sm border border-white/40 rounded-md text-[10px] font-black text-blue-800 uppercase tracking-widest shadow-sm">
                                {{ $genre->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-black tracking-tighter leading-none mb-2 drop-shadow-md text-gray-900">
                        {{ $story->title }}
                    </h1>
                    
                    <p class="text-sm md:text-lg font-bold text-gray-600 mb-6 drop-shadow-sm flex items-center justify-center md:justify-start gap-2">
                        <span class="text-gray-400 font-medium text-xs uppercase tracking-widest">By</span>
                        {{ $story->author->name ?? 'Unknown Author' }}
                        <svg class="w-4 h-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>
                    </p>

                    <!-- Quick Stats Row (Scrollable on mobile) -->
                    <div class="flex items-center gap-4 md:gap-8 overflow-x-auto pb-2 scrollbar-hide w-full justify-center md:justify-start">
                        <a href="{{ route('story.map', $story->slug) }}" class="flex flex-col items-center md:items-start flex-shrink-0 group/stat">
                            <span class="flex items-center gap-1.5 text-lg font-black text-blue-600 group-hover/stat:scale-110 transition-transform">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                                Map
                            </span>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">Explore World</span>
                        </a>

                        <div class="w-px h-8 bg-gray-300 flex-shrink-0"></div>

                        <div class="flex flex-col items-center md:items-start flex-shrink-0">
                            <span class="flex items-center gap-1.5 text-lg font-black text-gray-900">
                                <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                                4.8
                            </span>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">Rating</span>
                        </div>
                        
                        <div class="w-px h-8 bg-gray-300 flex-shrink-0"></div>
                        
                        <div class="flex flex-col items-center md:items-start flex-shrink-0">
                            <span class="flex items-center gap-1.5 text-lg font-black text-gray-900">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                {{ number_format($story->views_count / 1000, 1) }}k
                            </span>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">Views</span>
                        </div>

                        <div class="w-px h-8 bg-gray-300 flex-shrink-0"></div>

                        <div class="flex flex-col items-center md:items-start flex-shrink-0">
                            <span class="flex items-center gap-1.5 text-lg font-black text-gray-900">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                {{ count($chapters) }}
                            </span>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">Chapters</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Read Button (Mobile Sticky) -->
    <div class="fixed bottom-16 md:bottom-auto md:static left-0 w-full p-4 md:p-0 z-40 md:z-0 bg-gradient-to-t from-gray-50 via-gray-50 to-transparent md:bg-none">
        <div class="max-w-5xl mx-auto md:px-8 flex items-center gap-3">
            @if(count($chapters) > 0)
            <a href="{{ route('story.reader', ['slug' => $story->slug, 'chapterId' => $chapters[0]->id]) }}" class="flex-1 md:flex-none md:w-64 h-14 rounded-2xl bg-gradient-to-r from-blue-600 to-pink-600 text-white font-black text-sm uppercase tracking-widest shadow-lg shadow-pink-500/30 flex items-center justify-center gap-2 hover:scale-105 active:scale-95 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M5 3l14 9-14 9V3z"/></svg>
                Start Reading
            </a>
            @else
            <button disabled class="flex-1 md:flex-none md:w-64 h-14 rounded-2xl bg-gray-200 text-gray-400 font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2 cursor-not-allowed">
                No Chapters Yet
            </button>
            @endif
            <button class="w-14 h-14 rounded-2xl bg-white border border-gray-200 text-gray-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 flex items-center justify-center shadow-sm transition-all flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </button>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="max-w-5xl mx-auto px-4 md:px-8 mt-6 md:mt-12" x-data="{ tab: 'about' }">
        
        <!-- Tab Navigation -->
        <div class="flex items-center gap-6 border-b border-gray-200 mb-8 overflow-x-auto scrollbar-hide">
            <button @click="tab = 'about'" class="pb-3 text-sm font-black uppercase tracking-widest border-b-2 transition-colors whitespace-nowrap" :class="tab === 'about' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-400 hover:text-gray-600'">
                About
            </button>
            <button @click="tab = 'chapters'" class="pb-3 text-sm font-black uppercase tracking-widest border-b-2 transition-colors whitespace-nowrap" :class="tab === 'chapters' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-400 hover:text-gray-600'">
                Chapters <span class="ml-1 bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-[10px]">{{ count($chapters) }}</span>
            </button>
            <button @click="tab = 'reviews'" class="pb-3 text-sm font-black uppercase tracking-widest border-b-2 transition-colors whitespace-nowrap" :class="tab === 'reviews' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-400 hover:text-gray-600'">
                Reviews
            </button>
        </div>

        <!-- About Tab -->
        <div x-show="tab === 'about'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="grid md:grid-cols-3 gap-8 md:gap-12">
            
            <div class="md:col-span-2 space-y-8">
                <!-- Synopsis -->
                <div>
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Synopsis</h3>
                    <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed font-medium">
                        {{ $story->synopsis ?? 'No synopsis available for this story yet. The author is likely crafting an epic tale.' }}
                    </div>
                </div>

                <!-- Tags -->
                <div>
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Magic', 'Reincarnation', 'Action', 'System', 'Overpowered'] as $tag)
                            <a href="#" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[11px] font-bold uppercase tracking-wider rounded-lg transition-colors"># {{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Author Sidebar -->
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm h-fit">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">About Author</h3>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-blue-100 to-pink-100 flex items-center justify-center text-blue-800 font-black text-xl flex-shrink-0">
                        {{ substr($story->author->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-black text-gray-900 leading-tight">{{ $story->author->name ?? 'Unknown' }}</h4>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Author</p>
                    </div>
                </div>
                <button class="w-full py-2.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl text-xs font-black uppercase tracking-widest transition-colors">
                    Follow
                </button>
            </div>
        </div>

        <!-- Chapters Tab -->
        <div x-show="tab === 'chapters'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-3 pb-8">
            @foreach($chapters as $chapter)
                <a href="{{ route('story.reader', ['slug' => $story->slug, 'chapterId' => $chapter->id]) }}" class="flex items-center gap-4 p-4 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors flex-shrink-0 font-black text-sm">
                        {{ $loop->iteration }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-black text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ $chapter->title }}</h4>
                        <div class="flex items-center gap-3 mt-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <span>{{ $chapter->created_at->diffForHumans() }}</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg> {{ number_format($chapter->views_count ?? 0) }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Reviews Tab Placeholder -->
        <div x-show="tab === 'reviews'" style="display: none;" class="py-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-1">No Reviews Yet</h3>
            <p class="text-sm text-gray-500 font-medium">Be the first to review this epic story.</p>
            <button class="mt-6 px-6 py-2.5 bg-gray-900 text-white rounded-full text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-colors">Write a Review</button>
        </div>

    </div>
</div>
@endsection
