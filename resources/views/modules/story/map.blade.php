@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f4ece1] pb-20 pt-10 px-4 md:px-0" x-data="storyMap({{ $story->id }}, {{ $locations->toJson() }}, {{ $story->author_id === Auth::id() ? 'true' : 'false' }})">
    <div class="max-w-6xl mx-auto">
        
        <!-- Map Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                    <a href="{{ route('story.show', $story->slug) }}" class="hover:text-blue-600 transition-colors">{{ $story->title }}</a>
                    <span>/</span>
                    <span class="text-gray-900">World Map</span>
                </nav>
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter">The World of Lore</h1>
            </div>
            
            @if($story->author_id === Auth::id())
            <div class="flex items-center gap-3">
                <div x-show="isEditor" x-transition class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-500/20">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    Editor Mode Active
                </div>
                <button @click="toggleEditor" class="px-6 py-2.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-md">
                    <span x-text="isEditor ? 'Exit Editor' : 'Open Editor'"></span>
                </button>
            </div>
            @endif
        </div>

        <!-- Map Container -->
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl border-8 border-white overflow-hidden aspect-video group cursor-crosshair" 
             @click="handleMapClick($event)"
             id="map-container">
            
            <!-- Map Image -->
            <img src="{{ $story->map_image ?? 'https://images.unsplash.com/photo-1580137189272-c9379f8864fd?auto=format&fit=crop&q=80&w=2000' }}" 
                 class="w-full h-full object-cover select-none pointer-events-none opacity-90 group-hover:opacity-100 transition-opacity duration-700"
                 alt="Fantasy Map">
            
            <!-- Markers -->
            <template x-for="loc in locations" :key="loc.id">
                <div class="absolute -translate-x-1/2 -translate-y-1/2 group/marker"
                     :style="`left: ${loc.x_pos}%; top: ${loc.y_pos}%;`"
                     @click.stop="selectedLocation = loc">
                    
                    <!-- Pulse effect -->
                    <div class="absolute inset-0 w-8 h-8 -left-1 -top-1 bg-blue-500/20 rounded-full animate-ping"></div>
                    
                    <!-- Marker Icon -->
                    <div class="relative w-6 h-6 bg-white rounded-full shadow-xl border-2 border-blue-600 flex items-center justify-center text-blue-600 transition-transform group-hover/marker:scale-125 cursor-pointer">
                        <svg x-show="loc.type === 'city'" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                        <svg x-show="loc.type === 'dungeon'" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 21v-4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4"/><circle cx="12" cy="7" r="5"/></svg>
                        <svg x-show="loc.type === 'kingdom'" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/><path d="M12 11h.01"/><path d="M12 7h.01"/><path d="M12 15h.01"/><path d="M12 19h.01"/><path d="M7 21h10"/></svg>
                    </div>

                    <!-- Label -->
                    <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-gray-900/80 backdrop-blur-md text-white px-2 py-0.5 rounded-md text-[8px] font-black uppercase tracking-widest whitespace-nowrap opacity-0 group-hover/marker:opacity-100 transition-opacity pointer-events-none">
                        <span x-text="loc.name"></span>
                    </div>
                </div>
            </template>

            <!-- Editor Preview Pin -->
            <div x-show="isEditor && previewPin" 
                 class="absolute -translate-x-1/2 -translate-y-1/2 pointer-events-none"
                 :style="`left: ${previewPin.x}%; top: ${previewPin.y}%;`"
                 style="display: none;">
                <div class="w-8 h-8 bg-pink-500/20 rounded-full animate-pulse border-2 border-pink-500"></div>
            </div>

            <!-- Hint overlay for editor -->
            <div x-show="isEditor" x-transition class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-gray-900/90 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-2xl z-20 pointer-events-none">
                Click anywhere on the map to place a new location
            </div>
        </div>

        <!-- Location Sidebar / Detail -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 space-y-6">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Map Legends</h3>
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-900 uppercase">Settlements</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Cities & Villages</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 21v-4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v4"/><circle cx="12" cy="7" r="5"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-900 uppercase">Dungeons</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Ruins & Caves</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div x-show="selectedLocation" x-transition class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-xl min-h-[300px] flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest" x-text="selectedLocation?.type"></span>
                            <h2 class="text-3xl font-black text-gray-900 tracking-tighter mt-3" x-text="selectedLocation?.name"></h2>
                        </div>
                        <button @click="selectedLocation = null" class="text-gray-400 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </button>
                    </div>
                    <p class="text-gray-600 leading-relaxed font-medium" x-text="selectedLocation?.description"></p>
                    
                    <div class="mt-auto pt-8 border-t border-gray-100 flex items-center gap-4">
                        <button class="px-8 py-3 bg-gray-900 text-white text-xs font-black uppercase tracking-widest rounded-full hover:bg-gray-800 transition-all">Explore Chronicles</button>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">3 related chapters</p>
                    </div>
                </div>

                <div x-show="!selectedLocation" class="bg-gray-100/50 p-8 rounded-[2.5rem] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-center h-full min-h-[300px]">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    </div>
                    <p class="text-gray-500 font-bold max-w-xs">Select a marker on the map to explore the secrets of LoreVerse.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Location Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-md">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl" @click.away="showCreateModal = false">
            <h2 class="text-2xl font-black text-gray-900 tracking-tighter mb-6">New Location</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Location Name</label>
                    <input type="text" x-model="newLocation.name" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Type</label>
                    <select x-model="newLocation.type" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-blue-500/20">
                        <option value="city">City / Village</option>
                        <option value="kingdom">Kingdom</option>
                        <option value="dungeon">Dungeon / Ruin</option>
                        <option value="landmark">Natural Landmark</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Description</label>
                    <textarea x-model="newLocation.description" rows="4" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm font-medium focus:ring-2 focus:ring-blue-500/20"></textarea>
                </div>
                <div class="flex items-center gap-3 pt-4">
                    <button @click="saveLocation" class="flex-1 py-4 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all">Save Location</button>
                    <button @click="showCreateModal = false" class="px-6 py-4 bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-gray-200 transition-all">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function storyMap(storyId, initialLocations, canEdit) {
        return {
            storyId: storyId,
            locations: initialLocations,
            isEditor: false,
            canEdit: canEdit,
            selectedLocation: null,
            showCreateModal: false,
            previewPin: null,
            newLocation: {
                name: '',
                type: 'city',
                description: '',
                x_pos: 0,
                y_pos: 0
            },

            toggleEditor() {
                this.isEditor = !this.isEditor;
                if (!this.isEditor) this.previewPin = null;
            },

            handleMapClick(e) {
                if (!this.isEditor) return;

                const rect = document.getElementById('map-container').getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;

                this.previewPin = { x, y };
                this.newLocation.x_pos = x;
                this.newLocation.y_pos = y;
                this.showCreateModal = true;
            },

            async saveLocation() {
                try {
                    const response = await axios.post(`/story/${this.storyId}/location`, this.newLocation);
                    this.locations.push(response.data);
                    this.showCreateModal = false;
                    this.previewPin = null;
                    this.newLocation = { name: '', type: 'city', description: '', x_pos: 0, y_pos: 0 };
                } catch (e) {
                    alert('Failed to save location');
                    console.error(e);
                }
            }
        }
    }
</script>
@endsection
