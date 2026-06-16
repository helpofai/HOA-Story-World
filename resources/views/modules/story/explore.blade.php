@extends('layouts.app')

@section('content')
<div class="pb-24 min-h-screen bg-gray-50">
    <!-- Header/Search Section -->
    <div class="bg-white border-b border-gray-100 pt-6 pb-4 px-4 md:px-8 sticky top-14 z-40">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight mb-4">Explore Stories</h1>
            
            <!-- Large Mobile Search -->
            <div class="md:hidden relative group mb-6">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                </div>
                <input type="text" class="block w-full pl-11 pr-4 py-3.5 bg-gray-100 border-none rounded-2xl text-sm placeholder-gray-500 font-bold focus:ring-4 focus:ring-blue-500/10 focus:bg-white transition-all shadow-inner" placeholder="Search titles, authors, or genres...">
            </div>

            <!-- Genre Filters -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                <a href="/explore" class="flex-shrink-0 px-4 py-2 rounded-full text-[11px] font-black uppercase tracking-widest transition-all {{ !$currentGenre ? 'bg-gray-900 text-white shadow-md' : 'bg-white text-gray-500 hover:bg-gray-100 border border-gray-200' }}">
                    All
                </a>
                @foreach($genres as $genre)
                    <a href="/explore?genre={{ $genre->slug }}" class="flex-shrink-0 px-4 py-2 rounded-full text-[11px] font-black uppercase tracking-widest transition-all {{ $currentGenre === $genre->slug ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-white text-gray-500 hover:bg-gray-100 border border-gray-200' }}">
                        {{ $genre->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Stories Grid -->
    <div class="px-4 md:px-8 py-8 max-w-7xl mx-auto">
        
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-black text-gray-900 tracking-tight">
                {{ $currentGenre ? ucfirst($currentGenre) . ' Stories' : 'Trending Now' }}
            </h2>
            <div class="flex items-center gap-2">
                <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors rounded-lg hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
            @foreach($stories as $story)
                <a href="{{ route('story.show', ['slug' => $story->slug ?? 'demo-slug']) }}" class="group relative flex flex-col gap-2">
                    <div class="aspect-[2/3] w-full rounded-2xl overflow-hidden bg-gray-200 relative shadow-sm transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-1">
                        @if($story->cover_image)
                            <img src="{{ $story->cover_image }}" alt="{{ $story->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center p-4">
                                <span class="text-center font-black text-indigo-900/40 text-lg leading-tight">{{ $story->title }}</span>
                            </div>
                        @endif
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Rating Badge -->
                        <div class="absolute top-2 right-2 px-2 py-1 bg-black/50 backdrop-blur-md rounded-lg flex items-center gap-1">
                            <svg class="w-3 h-3 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                            <span class="text-[10px] font-bold text-white">4.8</span>
                        </div>
                    </div>
                    
                    <div class="px-1">
                        <h3 class="font-black text-sm text-gray-900 leading-tight line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $story->title }}</h3>
                        <p class="text-[11px] font-bold text-gray-400 mt-1 uppercase tracking-wider line-clamp-1">{{ $story->author->name ?? 'Unknown' }}</p>
                        
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-[10px] font-medium text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">{{ number_format($story->views_count ?? 0) }} Views</span>
                            @if($story->genres->isNotEmpty())
                                <span class="text-[10px] font-medium text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">{{ $story->genres->first()->name }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $stories->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
