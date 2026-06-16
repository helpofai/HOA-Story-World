@extends('layouts.app')

@section('content')
<div class="min-h-screen pb-20 pt-10 px-4 md:px-0">
    <div class="max-w-4xl mx-auto" x-data="storyCreator()">
        
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter mb-2">Create New Story</h1>
            <p class="text-gray-500 font-medium">Define your story universe and start your writing journey.</p>
        </div>

        @if($errors->any())
        <div class="mb-8 p-6 bg-red-50 border-2 border-red-100 rounded-[2rem] animate-shake">
            <h3 class="text-red-800 font-black text-xs uppercase tracking-widest mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Please fix the following:
            </h3>
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-red-600 text-sm font-bold tracking-tight">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('author.story.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left: Image Uploads -->
                <div class="md:col-span-1 space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 block">Story Cover</label>
                        <div class="aspect-[2/3] w-full bg-gray-100 rounded-[2rem] border-4 border-dashed border-gray-200 flex flex-col items-center justify-center relative overflow-hidden group cursor-pointer transition-all hover:border-blue-400">
                            <template x-if="coverPreview">
                                <img :src="coverPreview" class="absolute inset-0 w-full h-full object-cover">
                            </template>
                            <div class="flex flex-col items-center gap-2 group-hover:scale-110 transition-transform" x-show="!coverPreview">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-300"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Upload Cover</span>
                            </div>
                            <input type="file" name="cover_image" class="absolute inset-0 opacity-0 cursor-pointer" @change="previewCover">
                        </div>
                        <p class="mt-3 text-[10px] text-gray-400 font-medium text-center italic">Best size: 600x900px</p>
                    </div>
                </div>

                <!-- Right: Metadata Form -->
                <div class="md:col-span-2 space-y-8">
                    <!-- Title & Subtitle -->
                    <div class="space-y-4">
                        <div class="relative group">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Story Title</label>
                            <input type="text" name="title" required placeholder="The Last Kingdom" 
                                   class="w-full text-2xl font-black bg-white/50 border-2 border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder-gray-200">
                        </div>
                        <div class="relative group">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Subtitle (Optional)</label>
                            <input type="text" name="subtitle" placeholder="A tale of forgotten shadows" 
                                   class="w-full text-lg font-bold bg-white/50 border-2 border-gray-100 rounded-2xl px-5 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder-gray-200">
                        </div>
                    </div>

                    <!-- Synopsis -->
                    <div class="relative group">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block text-gray-400">Synopsis</label>
                        <textarea name="synopsis" required rows="6" placeholder="What is your story about?" 
                                  class="w-full bg-white/50 border-2 border-gray-100 rounded-3xl px-6 py-5 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder-gray-200 font-medium text-sm leading-relaxed"></textarea>
                    </div>

                    <!-- Genres (Multi-select) -->
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 block">Select Genres (At least 1)</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($genres as $genre)
                            <label class="cursor-pointer group">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="hidden peer">
                                <span class="px-4 py-2 rounded-full border-2 border-gray-100 text-xs font-black uppercase tracking-widest text-gray-400 group-hover:border-gray-200 transition-all peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-blue-500/20 block">
                                    {{ $genre->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Language, Age Rating & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Story Language</label>
                            <select name="language" class="w-full bg-white border-2 border-gray-100 rounded-2xl px-4 py-3 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                                <option value="en">English</option>
                                <option value="bn">Bengali (বাংলা)</option>
                                <option value="hi">Hindi (हिन्दी)</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Age Rating</label>
                            <select name="age_rating" class="w-full bg-white border-2 border-gray-100 rounded-2xl px-4 py-3 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                                @foreach($ageRatings as $rating)
                                <option value="{{ $rating }}">{{ $rating }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Initial Status</label>
                            <select name="status" class="w-full bg-white border-2 border-gray-100 rounded-2xl px-4 py-3 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                                @foreach($statuses as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-6">
                        <button type="submit" class="w-full md:w-auto px-12 py-5 bg-gradient-to-r from-blue-600 to-pink-600 text-white text-sm font-black uppercase tracking-[0.2em] rounded-full shadow-2xl shadow-pink-500/30 hover:shadow-pink-500/50 transition-all hover:scale-105 active:scale-95">
                            Create Universe & Start Writing
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function storyCreator() {
        return {
            coverPreview: null,
            previewCover(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.coverPreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    }
</script>
@endsection
