<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 overflow-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Writer Studio - {{ $story->title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900|merriweather:400,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .ProseMirror { outline: none !important; min-height: 60vh; padding-bottom: 20vh; }
        .ProseMirror p.is-editor-empty:first-child::before { color: #adb5bd; content: attr(data-placeholder); float: left; height: 0; pointer-events: none; }
        .ProseMirror p { margin-bottom: 1.5em; line-height: 1.8; font-size: 1.25rem; font-family: 'Merriweather', serif; }
        .ProseMirror h1 { font-size: 3rem; font-weight: 900; margin-bottom: 1em; letter-spacing: -0.025em; font-family: 'Instrument Sans', sans-serif;}
        .ProseMirror h2 { font-size: 2rem; font-weight: 800; margin-bottom: 0.75em; margin-top: 1.5em; letter-spacing: -0.025em;}
        .ProseMirror blockquote { border-left: 4px solid #3b82f6; padding-left: 1.5rem; font-style: italic; color: #4b5563; background: #eff6ff; padding-top: 1rem; padding-bottom: 1rem; border-radius: 0 1rem 1rem 0; }
        .ProseMirror mark { background-color: #fef08a; padding: 0.1em 0.2em; border-radius: 0.2em; }
        .character-mention { background-color: #eff6ff; color: #1d4ed8; font-weight: 600; padding: 0.125rem 0.375rem; border-radius: 0.25rem; cursor: pointer; }

        .studio-focus-mode .sidebar, .studio-focus-mode .right-sidebar { opacity: 0; pointer-events: none; }
        .studio-focus-mode .sidebar { transform: translateX(-40px); }
        .studio-focus-mode .right-sidebar { transform: translateX(40px); }
        .studio-focus-mode .topbar { opacity: 0; transform: translateY(-100%); }
        .studio-focus-mode main { max-width: 900px !important; }
        .transition-studio { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Bubble Menu Styles */
        .bubble-menu { display: flex; background-color: #0f172a; padding: 0.4rem; border-radius: 0.8rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255,255,255,0.1); }
        .bubble-menu button { border: none; background: none; color: #fff; padding: 0.4rem 0.6rem; border-radius: 0.4rem; cursor: pointer; font-weight: bold; font-size: 0.75rem; transition: background 0.2s; }
        .bubble-menu button:hover { background-color: rgba(255,255,255,0.1); }
        .bubble-menu button.is-active { color: #3b82f6; background-color: rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="h-full font-sans antialiased text-gray-900 select-none bg-[#fdfdfd] flex flex-col transition-colors duration-500" 
      x-data="studioManager()"
      data-chapter-id="{{ $chapter->id }}"
      @editor-ready.window="editor = $event.detail.editor">
    
    <!-- Bubble Menu -->
    <div id="bubble-menu" class="bubble-menu" x-show="editor" style="display: none;">
        <button @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor?.isActive('bold') }">B</button>
        <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor?.isActive('italic') }">I</button>
        <button @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor?.isActive('strike') }">S</button>
        <button @click="editor.chain().focus().toggleHighlight().run()" :class="{ 'is-active': editor?.isActive('highlight') }">H</button>
        <div class="w-px h-4 bg-white/20 mx-1 self-center"></div>
        <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor?.isActive('heading', { level: 1 }) }">H1</button>
        <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor?.isActive('heading', { level: 2 }) }">H2</button>
        <button @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor?.isActive('blockquote') }">Quote</button>
    </div>

    <!-- Top Toolbar -->
    <header class="topbar h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 z-40 flex-shrink-0 transition-studio relative shadow-sm">
        <div class="flex items-center gap-4 flex-1">
            <a href="/dashboard" class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div class="h-6 w-px bg-gray-200"></div>
            <div class="min-w-0">
                <h1 class="text-sm font-black text-gray-900 leading-tight truncate">{{ $story->title }}</h1>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">Chapter {{ $chapter->order_index }}</p>
            </div>
        </div>

        <div class="flex items-center justify-center flex-1">
            <div class="flex items-center gap-2 px-6 py-2 bg-gray-50 rounded-2xl border border-gray-100 shadow-inner">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">Chapter Target</span>
                <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full transition-all duration-1000" :style="'width: ' + Math.min(100, (words / 2000) * 100) + '%'"></div>
                </div>
                <span class="text-[10px] font-black text-blue-600 ml-2" x-text="words + ' / 2k'"></span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-6 flex-1">
            <div class="flex items-center gap-2">
                <span :class="{ 'bg-green-500': saveStatus === 'Saved', 'bg-yellow-500': saveStatus === 'Saving...', 'bg-red-500': saveStatus === 'Error' }" class="w-2 h-2 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest" x-text="saveStatus">Saved</span>
            </div>
            <button @click="toggleFocusMode" class="p-2 text-gray-400 hover:text-gray-900 transition-colors rounded-lg hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/></svg>
            </button>
            <button class="px-6 py-2.5 text-xs font-black uppercase tracking-widest text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">Publish</button>
        </div>
    </header>

    <div class="flex-1 flex overflow-hidden relative">
        
        <!-- Left Sidebar: Story Bible -->
        <aside class="sidebar w-64 bg-gray-50 border-r border-gray-100 flex-shrink-0 flex flex-col transition-studio z-30">
            <div class="flex-1 overflow-y-auto p-4 space-y-8 scrollbar-hide">
                <!-- Chapters -->
                <div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center justify-between">
                        Chapters 
                        <form action="{{ route('author.studio.chapter.create', $story->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </form>
                    </h3>
                    <div class="space-y-1">
                        @foreach($allChapters as $c)
                        <a href="?chapter_id={{ $c->id }}" class="block px-3 py-2.5 {{ $chapter->id == $c->id ? 'bg-white text-blue-700 font-bold border border-gray-100 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100 font-medium' }} rounded-xl text-sm transition-all truncate">
                            <span class="opacity-40 mr-2">#{{ $loop->iteration }}</span> {{ $c->title ?? 'Untitled Chapter' }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Story Bible: Characters -->
                <div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Story Bible</h3>
                    <div class="space-y-3">
                        @foreach($characters as $char)
                        <div class="flex items-center gap-3 p-3 bg-white border border-gray-100 rounded-2xl cursor-pointer hover:border-blue-400 hover:shadow-md transition-all group">
                            <div class="w-10 h-10 rounded-full bg-{{ $char->color_theme ?? 'blue' }}-100 flex items-center justify-center text-{{ $char->color_theme ?? 'blue' }}-700 font-black text-xs group-hover:scale-110 transition-transform">
                                {{ $char->initials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-black text-gray-900 truncate">{{ $char->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $char->role }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Story Bible: Timeline -->
                @if($timelineEvents->count() > 0)
                <div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">World History</h3>
                    <div class="space-y-4">
                        @foreach($timelineEvents as $event)
                        <div class="p-4 bg-white border border-gray-100 rounded-2xl relative overflow-hidden group hover:border-blue-400 transition-all">
                            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500 opacity-20 group-hover:opacity-100 transition-opacity"></div>
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Year {{ $event->year }}</p>
                            <p class="text-xs text-gray-900 font-bold leading-relaxed">{{ $event->title }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </aside>

        <!-- Editor -->
        <main class="flex-1 bg-white relative overflow-y-auto scrollbar-hide flex justify-center z-10 shadow-[0_0_50px_rgba(0,0,0,0.02)]">
            <div class="w-full max-w-[850px] px-10 py-20 md:px-16 md:py-32">
                <div class="mb-16 group">
                    <input id="chapter-title-input" type="text" value="{{ $chapter->title }}" class="w-full text-5xl md:text-6xl font-black text-gray-900 placeholder-gray-200 border-none outline-none focus:ring-0 p-0 bg-transparent tracking-tighter transition-all" placeholder="Chapter Title">
                    <div class="h-1 w-20 bg-blue-500 mt-4 rounded-full group-focus-within:w-40 transition-all duration-500"></div>
                    <input id="chapter-subtitle-input" type="text" value="{{ $chapter->subtitle }}" class="w-full text-xl md:text-2xl font-bold text-gray-400 placeholder-gray-100 border-none outline-none focus:ring-0 p-0 mt-6 bg-transparent tracking-tight" placeholder="Chapter Subtitle (Optional)">
                </div>

                <div id="tiptap-editor" class="font-serif text-gray-800 prose prose-xl prose-blue max-w-none">
                    {!! $chapter->content !!}
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="right-sidebar w-72 bg-gray-50 border-l border-gray-100 flex-shrink-0 flex flex-col transition-studio z-30">
            <div class="p-6 border-b border-gray-100 bg-white">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Session Goals</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-[10px] font-black text-gray-500 uppercase">Words</span>
                            <span class="text-[10px] font-black text-blue-600" x-text="words"></span>
                        </div>
                        <div class="w-full h-1.5 bg-gray-100 rounded-full">
                            <div class="h-full bg-blue-500 rounded-full" :style="'width: ' + Math.min(100, (words / 2000) * 100) + '%'"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-blue-50 p-3 rounded-2xl border border-blue-100">
                            <p class="text-xl font-black text-blue-900 tracking-tighter" x-text="readingTime"></p>
                            <p class="text-[8px] font-black text-blue-400 uppercase tracking-widest">Read Time</p>
                        </div>
                        <div class="bg-pink-50 p-3 rounded-2xl border border-pink-100">
                            <p class="text-xl font-black text-pink-900 tracking-tighter">0%</p>
                            <p class="text-[8px] font-black text-pink-400 uppercase tracking-widest">Quality Score</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-8 scrollbar-hide">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Lore Assistant</h3>
                    </div>
                    <div class="bg-gradient-to-br from-purple-600 to-blue-600 p-4 rounded-3xl text-white text-xs font-medium leading-relaxed shadow-lg shadow-purple-500/20">
                        <p class="mb-3">I've noticed you're writing about <span class="font-black underline">The Great Hall</span>.</p>
                        <p class="opacity-80">Would you like me to suggest a more vivid description or check for character consistency?</p>
                        <button class="mt-4 w-full py-2 bg-white/20 hover:bg-white/30 rounded-xl font-black uppercase tracking-widest transition-colors">Ask Assistant</button>
                    </div>
                </div>

                <div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Writing Prompts</h3>
                    <div class="space-y-3">
                        <button class="w-full text-left p-3 bg-white border border-gray-100 rounded-2xl text-[11px] text-gray-600 hover:border-blue-400 transition-all font-medium">Describe the smells of the tavern...</button>
                        <button class="w-full text-left p-3 bg-white border border-gray-100 rounded-2xl text-[11px] text-gray-600 hover:border-blue-400 transition-all font-medium">A sudden noise from the shadows...</button>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('studioManager', () => ({
                editor: null,
                words: 0,
                characters: 0,
                readingTime: '0m',
                saveStatus: 'Saved',
                isFocusMode: false,

                init() {
                    document.addEventListener('editorUpdate', (e) => {
                        this.words = e.detail.words;
                        this.characters = e.detail.characters;
                        this.readingTime = Math.max(1, Math.ceil(this.words / 200)) + 'm';
                    });

                    document.addEventListener('saveStateChange', (e) => {
                        if (e.detail === 'saving') this.saveStatus = 'Saving...';
                        if (e.detail === 'saved') this.saveStatus = 'Saved';
                        if (e.detail === 'error') this.saveStatus = 'Error';
                    });
                },

                formatNumber(n) {
                    return n >= 1000 ? (n/1000).toFixed(1) + 'k' : n;
                },

                toggleFocusMode() {
                    this.isFocusMode = !this.isFocusMode;
                    document.body.classList.toggle('studio-focus-mode', this.isFocusMode);
                },

                addImage() {
                    const url = window.prompt('Enter image URL');
                    if (url) {
                        this.editor.chain().focus().setImage({ src: url }).run();
                    }
                }
            }));
        });
    </script>
</body>
</html>
