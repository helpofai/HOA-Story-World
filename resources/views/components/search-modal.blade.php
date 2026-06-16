<div x-data="searchSystem()" 
     @keydown.window.ctrl.k.prevent="openSearch()"
     @keydown.window.cmd.k.prevent="openSearch()"
     @open-search.window="openSearch()"
     @keydown.window.escape="closeSearch()"
     class="relative z-[100]">
    
    <!-- Modal Backdrop -->
    <div x-show="isOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/40 backdrop-blur-md"
         style="display: none;"></div>

    <!-- Modal Content -->
    <div x-show="isOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20"
         style="display: none;"
         @click.away="closeSearch()">
        
        <div class="mx-auto max-w-2xl transform divide-y divide-gray-100 overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
            <div class="relative">
                <svg class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
                <input type="text" 
                       x-model="query"
                       x-ref="searchInput"
                       @input.debounce.300ms="search()"
                       class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm" 
                       placeholder="Search stories, authors, universes..." 
                       role="combobox" 
                       aria-expanded="false" 
                       aria-controls="options">
            </div>

            <!-- Results -->
            <ul x-show="results.length > 0" class="max-h-96 scroll-py-3 overflow-y-auto p-3" id="options" role="listbox">
                <template x-for="item in results" :key="item.id">
                    <li class="group flex cursor-default select-none items-center rounded-xl p-3 hover:bg-gray-50 transition-colors">
                        <a :href="item.url" class="flex items-center gap-4 w-full">
                            <div class="h-14 w-10 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                <img :src="item.cover" class="h-full w-full object-cover">
                            </div>
                            <div class="flex-auto">
                                <p class="text-sm font-black text-gray-900" x-text="item.title"></p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" x-text="item.author"></p>
                            </div>
                            <div class="flex-none">
                                <span class="rounded-full bg-blue-50 px-2 py-1 text-[9px] font-black text-blue-600 uppercase tracking-widest" x-text="item.genre"></span>
                            </div>
                        </a>
                    </li>
                </template>
            </ul>

            <!-- Empty State / Loading -->
            <div x-show="query.length >= 2 && results.length === 0 && !loading" class="px-6 py-14 text-center sm:px-14">
                <svg class="mx-auto h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-4 text-sm text-gray-900 font-bold">No stories found.</p>
                <p class="mt-2 text-xs text-gray-500">Try searching for something else or browse genres.</p>
            </div>

            <!-- Default State -->
            <div x-show="query.length < 2 && !loading" class="px-6 py-10 sm:px-14">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Trending Searches</h3>
                <div class="flex flex-wrap gap-2">
                    <button @click="query = 'Kingdom'; search()" class="px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-200">#Kingdom</button>
                    <button @click="query = 'Magic'; search()" class="px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-200">#Magic</button>
                    <button @click="query = 'Cyberpunk'; search()" class="px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-200">#Cyberpunk</button>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between bg-gray-50 px-4 py-2.5 text-xs text-gray-500">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1"><kbd class="font-sans font-semibold text-gray-900 border border-gray-300 px-1 rounded bg-white">esc</kbd> to close</span>
                    <span class="flex items-center gap-1"><kbd class="font-sans font-semibold text-gray-900 border border-gray-300 px-1 rounded bg-white">↵</kbd> to select</span>
                </div>
                <div class="font-bold text-[10px] uppercase tracking-widest text-blue-600">Powered by HOA-Story-World</div>
            </div>
        </div>
    </div>
</div>

<script>
    function searchSystem() {
        return {
            isOpen: false,
            query: '',
            results: [],
            loading: false,

            openSearch() {
                this.isOpen = true;
                this.$nextTick(() => this.$refs.searchInput.focus());
            },

            closeSearch() {
                this.isOpen = false;
                this.query = '';
                this.results = [];
            },

            async search() {
                if (this.query.length < 2) {
                    this.results = [];
                    return;
                }

                this.loading = true;
                try {
                    const response = await fetch(`/api/search?q=${encodeURIComponent(this.query)}`);
                    this.results = await response.json();
                } catch (e) {
                    console.error('Search failed', e);
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
