<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      class="h-full scroll-smooth"
      x-data="readerSettings()"
      :class="theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $chapter->title }} - {{ $story->title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,900|merriweather:400,700|lora:400,600|inter:400,600,800|hind-siliguri:400,600,700|hind:400,600,700|noto-sans-bengali:400,700|noto-sans-devanagari:400,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        
        /* Theme Definitions */
        .theme-light { --bg-reader: #ffffff; --text-reader: #111827; --border-reader: #f3f4f6; }
        .theme-sepia { --bg-reader: #f4ecd8; --text-reader: #5b4636; --border-reader: #e3d5b8; }
        .theme-dark { --bg-reader: #1a1a1a; --text-reader: #e5e7eb; --border-reader: #262626; }
        .theme-amoled { --bg-reader: #000000; --text-reader: #d1d5db; --border-reader: #111111; }

        body { background-color: var(--bg-reader); color: var(--text-reader); transition: background-color 0.3s, color 0.3s; }
        
        .reader-content { line-height: 1.8; }
        .reader-content p { margin-bottom: 1.5em; }

        /* Progress Bar */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(to right, #2563eb, #db2777);
            z-index: 100;
            width: 0%;
            transition: width 0.1s;
        }

        .font-serif-reading { font-family: 'Merriweather', serif; }
        .font-sans-reading { font-family: 'Instrument Sans', sans-serif; }
        .font-lora-reading { font-family: 'Lora', serif; }
        .font-bengali-reading { font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif; }
        .font-hindi-reading { font-family: 'Hind', 'Noto Sans Devanagari', sans-serif; }
        
        /* Floating controls auto-hide */
        .controls-overlay {
            transition: opacity 0.4s, transform 0.4s;
        }
        .controls-hidden { opacity: 0; pointer-events: none; transform: translateY(-10px); }
        .controls-bottom-hidden { transform: translateY(10px); }
    </style>
</head>
<body class="h-full selection:bg-blue-500/30 overflow-x-hidden" @scroll.window="updateProgress" @click="toggleControls">
    
    <div id="scroll-progress" :style="'width: ' + progress + '%'"></div>

    <!-- Top Navigation Overlay -->
    <header class="fixed top-0 left-0 w-full z-50 controls-overlay" :class="controlsVisible ? '' : 'controls-hidden'">
        <div class="bg-white/90 backdrop-blur-md border-b border-gray-100 dark:bg-black/80 dark:border-gray-800 px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('story.show', $story->slug) }}" class="p-2 hover:bg-gray-100 dark:hover:bg-white/10 rounded-full transition-colors text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="text-xs font-black truncate max-w-[150px] sm:max-w-[300px]">{{ $chapter->title }}</h1>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $story->title }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button @click.stop="showSettings = !showSettings" class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 rounded-full transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12h16"/><path d="M4 6h16"/><path d="M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="w-full max-w-3xl mx-auto px-6 pt-24 pb-32">
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-5xl font-black tracking-tighter mb-4" :class="getFontClass()">{{ $chapter->title }}</h1>
            @if($chapter->subtitle)
                <p class="text-xl font-bold opacity-60 tracking-tight">{{ $chapter->subtitle }}</p>
            @endif
            <div class="mt-8 flex items-center justify-center gap-3 text-[10px] font-black uppercase tracking-widest opacity-40">
                <span>{{ number_format($chapter->words_count) }} Words</span>
                <span>•</span>
                <span>{{ ceil($chapter->words_count / 200) }} Min Read</span>
            </div>
        </div>

        <article class="reader-content text-lg md:text-xl selection:bg-blue-500/20" 
                 :class="getFontClass()"
                 :style="'font-size: ' + fontSize + 'px; line-height: ' + lineHeight">
            {!! $chapter->content !!}
        </article>

        <!-- Chapter Navigation -->
        <div class="mt-20 flex flex-col items-center gap-8 pb-20">
            <div class="w-12 h-1 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
            
            <div class="w-full flex gap-4">
                @if($prevChapter)
                <a href="{{ route('story.reader', ['slug' => $story->slug, 'chapterId' => $prevChapter->id]) }}" class="flex-1 p-6 bg-white/5 dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-3xl hover:border-blue-500 transition-all group">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-blue-500">Previous</p>
                    <h4 class="mt-2 font-black text-sm truncate">{{ $prevChapter->title }}</h4>
                </a>
                @endif

                @if($nextChapter)
                <a href="{{ route('story.reader', ['slug' => $story->slug, 'chapterId' => $nextChapter->id]) }}" class="flex-1 p-6 bg-white/5 dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-3xl hover:border-pink-500 transition-all text-right group">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-pink-500">Next Chapter</p>
                    <h4 class="mt-2 font-black text-sm truncate">{{ $nextChapter->title }}</h4>
                </a>
                @endif
            </div>

            @if(!$nextChapter)
            <div class="text-center space-y-4">
                <p class="text-sm font-bold opacity-60">You've reached the end of the available chapters.</p>
                <a href="{{ route('story.show', $story->slug) }}" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-pink-600 text-white font-black uppercase tracking-widest text-xs rounded-full shadow-lg shadow-pink-500/20">Back to Story</a>
            </div>
            @endif
        </div>
    </main>

    <!-- Bottom Settings Drawer -->
    <div x-cloak 
         x-show="showSettings" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="fixed bottom-0 left-0 w-full z-[100] bg-white dark:bg-neutral-900 border-t border-gray-100 dark:border-white/5 rounded-t-[2.5rem] shadow-2xl p-8 md:p-12"
         @click.stop>
        
        <div class="max-w-2xl mx-auto space-y-10">
            <!-- Theme Selection -->
            <div>
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Reading Theme</h4>
                <div class="grid grid-cols-4 gap-3">
                    <button @click="theme = 'theme-light'" :class="theme === 'theme-light' ? 'ring-4 ring-blue-500/20 border-blue-500' : 'border-gray-100'" class="h-14 rounded-2xl bg-white border-2 flex items-center justify-center text-gray-900 font-bold text-xs">Light</button>
                    <button @click="theme = 'theme-sepia'" :class="theme === 'theme-sepia' ? 'ring-4 ring-blue-500/20 border-blue-500' : 'border-transparent'" class="h-14 rounded-2xl bg-[#f4ecd8] border-2 flex items-center justify-center text-[#5b4636] font-bold text-xs">Sepia</button>
                    <button @click="theme = 'theme-dark'" :class="theme === 'theme-dark' ? 'ring-4 ring-blue-500/20 border-blue-500' : 'border-transparent'" class="h-14 rounded-2xl bg-[#1a1a1a] border-2 flex items-center justify-center text-gray-300 font-bold text-xs">Dark</button>
                    <button @click="theme = 'theme-amoled'" :class="theme === 'theme-amoled' ? 'ring-4 ring-blue-500/20 border-blue-500' : 'border-transparent'" class="h-14 rounded-2xl bg-black border-2 flex items-center justify-center text-gray-400 font-bold text-xs">OLED</button>
                </div>
            </div>

            <!-- Typography -->
            <div class="grid md:grid-cols-1 gap-10">
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Font Family</h4>
                    <div class="flex flex-wrap gap-2 bg-gray-100 dark:bg-white/5 p-1 rounded-2xl">
                        <button @click="fontFamily = 'serif'" :class="fontFamily === 'serif' ? 'bg-white dark:bg-white/10 shadow-sm' : ''" class="px-4 py-3 rounded-xl font-serif text-xs">Merriweather</button>
                        <button @click="fontFamily = 'lora'" :class="fontFamily === 'lora' ? 'bg-white dark:bg-white/10 shadow-sm' : ''" class="px-4 py-3 rounded-xl font-lora text-xs">Lora</button>
                        <button @click="fontFamily = 'sans'" :class="fontFamily === 'sans' ? 'bg-white dark:bg-white/10 shadow-sm' : ''" class="px-4 py-3 rounded-xl font-sans text-xs font-bold">Sans</button>
                        <button @click="fontFamily = 'bengali'" :class="fontFamily === 'bengali' ? 'bg-white dark:bg-white/10 shadow-sm' : ''" class="px-4 py-3 rounded-xl font-bengali-reading text-xs font-bold">বাংলা (Hind)</button>
                        <button @click="fontFamily = 'hindi'" :class="fontFamily === 'hindi' ? 'bg-white dark:bg-white/10 shadow-sm' : ''" class="px-4 py-3 rounded-xl font-hindi-reading text-xs font-bold">हिन्दी (Hind)</button>
                    </div>
                </div>
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Text Size</h4>
                    <div class="flex items-center gap-6 px-2">
                        <button @click="fontSize = Math.max(14, fontSize - 2)" class="text-2xl font-black opacity-40 hover:opacity-100 transition-opacity">A-</button>
                        <div class="flex-1 h-1 bg-gray-200 dark:bg-white/10 rounded-full relative">
                            <div class="absolute top-1/2 left-0 h-4 w-4 bg-blue-600 rounded-full -translate-y-1/2 border-4 border-white dark:border-neutral-900 shadow-md" :style="'left: ' + ((fontSize - 14) / 16 * 100) + '%'"></div>
                        </div>
                        <button @click="fontSize = Math.min(30, fontSize + 2)" class="text-2xl font-black opacity-40 hover:opacity-100 transition-opacity">A+</button>
                    </div>
                </div>
            </div>

            <button @click="showSettings = false" class="w-full py-4 bg-gray-900 dark:bg-white dark:text-gray-900 rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl">Done Reading</button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('readerSettings', () => ({
                theme: localStorage.getItem('reader-theme') || 'theme-light',
                fontFamily: localStorage.getItem('reader-font') || '{{ $story->language === 'bn' ? 'bengali' : ($story->language === 'hi' ? 'hindi' : 'serif') }}',
                fontSize: parseInt(localStorage.getItem('reader-size')) || 18,
                lineHeight: 1.8,
                progress: 0,
                controlsVisible: true,
                showSettings: false,
                lastScroll: 0,

                init() {
                    this.$watch('theme', val => localStorage.setItem('reader-theme', val));
                    this.$watch('fontFamily', val => localStorage.setItem('reader-font', val));
                    this.$watch('fontSize', val => localStorage.setItem('reader-size', val));
                    this.updateProgress();

                    // Periodically sync progress with server if authenticated
                    if (document.body.dataset.chapterId) {
                        setInterval(() => {
                            if (this.progress > 0) {
                                axios.post(`/read/progress/${document.body.dataset.chapterId}`, {
                                    progress: this.progress
                                }).catch(e => console.error('Progress sync failed', e));
                            }
                        }, 5000); // Every 5 seconds
                    }
                },

                updateProgress() {
                    const scroll = window.scrollY;
                    const height = document.documentElement.scrollHeight - window.innerHeight;
                    this.progress = (scroll / height) * 100;

                    // Auto-hide controls on scroll down
                    if (scroll > this.lastScroll && scroll > 100) {
                        this.controlsVisible = false;
                    } else {
                        this.controlsVisible = true;
                    }
                    this.lastScroll = scroll;
                },

                toggleControls() {
                    if (!this.showSettings) {
                        this.controlsVisible = !this.controlsVisible;
                    }
                },

                getFontClass() {
                    if (this.fontFamily === 'serif') return 'font-serif-reading';
                    if (this.fontFamily === 'sans') return 'font-sans-reading';
                    if (this.fontFamily === 'lora') return 'font-lora-reading';
                    if (this.fontFamily === 'bengali') return 'font-bengali-reading';
                    if (this.fontFamily === 'hindi') return 'font-hindi-reading';
                    return '';
                }
            }));
        });
    </script>
</body>
</html>
