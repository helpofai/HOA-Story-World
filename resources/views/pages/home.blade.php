@extends('layouts.app')

@section('content')
<!-- GSAP & Hero Styles -->
<style>
    #interactive-hero-container {
        position: relative;
        overflow: hidden;
        font-family: "Inter", sans-serif;
        color: white;
        width: 100%;
    }
    .ih-card {
        position: absolute;
        left: 0;
        top: 0;
        background-position: center;
        background-size: cover;
        box-shadow: 6px 6px 20px 0px rgba(0, 0, 0, 0.4);
        border-radius: 16px;
        will-change: transform, left, top, width, height;
    }
    /* Add gradient overlay to cards for text readability */
    .ih-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%);
        border-radius: inherit;
        pointer-events: none;
    }
    .ih-card-content {
        position: absolute;
        left: 0;
        top: 0;
        color: #FFFFFF;
        padding-left: 16px;
        z-index: 40;
        pointer-events: none;
    }
    .ih-content-place { margin-top: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;}
    .ih-content-title-1, .ih-content-title-2 { font-weight: 900; font-size: 18px; text-transform: uppercase; line-height: 1.1; }
    .ih-content-start { wihdth: 20px; height: 3px; border-radius: 99px; background-color: #FFFFFF; }
    
    .ih-details {
        z-index: 22;
        position: absolute;
        top: 10%;
        left: 5%;
        max-width: 90%;
        pointer-events: none; 
    }
    @media (min-width: 768px) {
        .ih-details { top: 15%; left: 8%; max-width: 500px; }
    }
    .ih-details .ih-place-box { overflow: hidden; margin-bottom: 8px;}
    .ih-details .ih-place-box .ih-text { padding-top: 16px; font-size: 14px; position: relative; font-weight: 800; text-transform: uppercase; letter-spacing: 3px; color: #ecad29; }
    .ih-details .ih-place-box .ih-text:before { top: 0; left: 0; position: absolute; content: ""; width: 40px; height: 3px; border-radius: 99px; background-color: #ecad29; }
    
    .ih-details .ih-title-1, .ih-details .ih-title-2 { font-weight: 900; font-size: 48px; text-transform: uppercase; line-height: 1; text-shadow: 0 4px 30px rgba(0,0,0,0.6); }
    @media (min-width: 768px) {
        .ih-details .ih-title-1, .ih-details .ih-title-2 { font-size: 64px; }
    }
    .ih-details .ih-title-box-1, .ih-details .ih-title-box-2 { overflow: hidden; padding-bottom: 4px; }
    
    .ih-details .ih-desc { margin-top: 16px; font-size: 13px; font-weight: 500; text-shadow: 0 2px 10px rgba(0,0,0,0.8); line-height: 1.6; color: #e5e7eb; }
    @media (min-width: 768px) { .ih-details .ih-desc { font-size: 15px; } }
    
    .ih-details .ih-cta { margin-top: 24px; pointer-events: auto; }
    .ih-details .ih-discover { background: linear-gradient(to right, #2563eb, #db2777); border: none; padding: 14px 32px; border-radius: 99px; color: white; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 10px 25px -5px rgba(219, 39, 119, 0.5); font-size: 12px; }
    .ih-details .ih-discover:hover { transform: translateY(-2px); box-shadow: 0 15px 30px -5px rgba(219, 39, 119, 0.6); }
    .ih-details .ih-discover:active { transform: scale(0.95); }

    .ih-pagination { position: absolute; left: 0; top: 0; display: inline-flex; align-items: center; z-index: 60; pointer-events: auto;}
    .ih-pagination > .ih-arrow { width: 40px; height: 40px; border-radius: 999px; border: 2px solid rgba(255,255,255,0.2); display: grid; place-items: center; cursor: pointer; transition: all 0.2s; backdrop-filter: blur(4px); background: rgba(0,0,0,0.2); }
    .ih-pagination > .ih-arrow:hover { background: rgba(255,255,255,0.2); border-color: rgba(255,255,255,0.5); }
    .ih-pagination > .ih-arrow:nth-child(2) { margin-left: 12px; }
    .ih-pagination svg { width: 20px; height: 20px; color: white; }
    
    .ih-cover { position: absolute; inset: 0; background-color: #111827; z-index: 100; pointer-events: none;}
</style>

<div class="relative overflow-hidden w-full -mt-14">
    <!-- Decorative Background Blobs -->
    <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/20 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute top-1/2 right-0 translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-400/20 blur-[100px] rounded-full pointer-events-none"></div>

    <!-- Interactive Hero Section (Full Width) -->
    @if($sections['featured']->count() > 0)
    <div class="relative w-full z-10">
        <div id="interactive-hero-container" class="h-screen w-full bg-gray-900 group">
            
            <div id="ih-demo"></div>

            <div class="ih-details" id="ih-details-even">
                <div class="ih-place-box"><div class="ih-text">Featured</div></div>
                <div class="ih-title-box-1"><div class="ih-title-1">TITLE</div></div>
                <div class="ih-title-box-2"><div class="ih-title-2">HERE</div></div>
                <div class="ih-desc">Description goes here.</div>
                <div class="ih-cta">
                    <a href="#" class="ih-discover" id="ih-btn-even">Start Reading</a>
                </div>
            </div>

            <div class="ih-details" id="ih-details-odd">
                <div class="ih-place-box"><div class="ih-text">Featured</div></div>
                <div class="ih-title-box-1"><div class="ih-title-1">TITLE</div></div>
                <div class="ih-title-box-2"><div class="ih-title-2">HERE</div></div>
                <div class="ih-desc">Description goes here.</div>
                <div class="ih-cta">
                    <a href="#" class="ih-discover" id="ih-btn-odd">Start Reading</a>
                </div>
            </div>

            <div class="ih-pagination" id="ih-pagination">
                <div class="ih-arrow ih-arrow-left" id="ih-arrow-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </div>
                <div class="ih-arrow ih-arrow-right" id="ih-arrow-right">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </div>
            </div>

            <div class="ih-cover"></div>
        </div>
    </div>
    @endif

    <!-- Rest of content constrained -->
    <div class="relative px-4 py-12 space-y-12 z-10 max-w-7xl mx-auto">
        
        <!-- Continue Reading (Real History) -->
        @if(count($readingHistory) > 0)
        <section class="space-y-4 px-4 md:px-0">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-black text-gray-900 tracking-tight">Continue Reading</h2>
                <a href="/library" class="text-xs font-bold text-blue-600 uppercase tracking-widest">View History</a>
            </div>
            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                @foreach ($readingHistory as $history)
                <a href="{{ route('story.reader', ['slug' => $history->story->slug, 'chapterId' => $history->chapter_id]) }}" class="flex-shrink-0 w-[300px] bg-white/60 backdrop-blur-md border border-white/40 rounded-2xl p-3 flex gap-4 shadow-sm active:scale-[0.98] transition-transform">
                    <div class="w-20 h-24 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden">
                        @if($history->story->cover_image)
                            <img src="{{ $history->story->cover_image }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                        <h3 class="font-bold text-gray-900 truncate text-sm">{{ $history->story->title }}</h3>
                        <p class="text-[11px] text-gray-500 font-medium truncate">{{ $history->chapter->title }} • {{ round($history->progress_percent) }}%</p>
                        <div class="mt-3 w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-600 to-pink-600 rounded-full" style="width: {{ $history->progress_percent }}%"></div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Trending Stories -->
        <section class="space-y-5 px-4 md:px-0">
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <h2 class="text-xl font-black text-gray-900 tracking-tight">Trending Now</h2>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Most read this hour</p>
                </div>
                <a href="#" class="p-2 bg-white/50 backdrop-blur-sm border border-white/20 rounded-full text-gray-500 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                @foreach($sections['trending'] as $story)
                <a href="{{ route('story.show', ['slug' => $story->slug ?? 'demo-slug']) }}" class="flex-shrink-0 w-[140px] space-y-3 group cursor-pointer">
                    <div class="aspect-[2/3] bg-gray-100 rounded-2xl overflow-hidden relative shadow-sm group-active:scale-95 transition-all">
                        @if($story->cover_image)
                            <img src="{{ $story->cover_image }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="absolute bottom-2 left-2 flex flex-wrap gap-1">
                            @foreach($story->genres->take(1) as $genre)
                            <span class="px-1.5 py-0.5 bg-white/20 backdrop-blur-md rounded-md text-[8px] font-bold text-white uppercase">{{ $genre->name }}</span>
                            @endforeach
                        </div>
                        <div class="absolute top-2 right-2 px-1.5 py-0.5 bg-black/50 backdrop-blur-md rounded-lg text-[9px] font-black text-white flex items-center gap-1">
                            <svg class="text-yellow-400 fill-current" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            {{ number_format($story->rating, 1) }}
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-xs text-gray-900 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">{{ $story->title }}</h3>
                        <p class="text-[10px] text-gray-400 font-medium mt-1">{{ number_format($story->views_count / 1000, 1) }}K Views</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        
        <!-- Bottom spacing for mobile nav -->
        <div class="h-8"></div>
    </div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    if(!document.getElementById('interactive-hero-container')) return;

    // Prepare dynamic data from Laravel
    @php
        $heroData = $sections['featured']->take(6)->map(function($story) {
            $words = explode(' ', $story->title);
            $title1 = array_shift($words) ?? 'EPIC';
            $title2 = implode(' ', $words) ?? 'STORY';
            if(empty($title2)) $title2 = 'TALE';

            return [
                'place' => $story->genres->first()->name ?? 'Featured',
                'title' => Str::limit($title1, 15, ''),
                'title2' => Str::limit($title2, 20, '...'),
                'description' => Str::limit($story->synopsis, 120),
                'image' => $story->cover_image ?? 'https://picsum.photos/seed/'.$story->id.'/800/1200',
                'link' => route('story.show', ['slug' => $story->slug ?? 'demo-slug'])
            ];
        })->values();
    @endphp
    const rawData = @json($heroData);

    // Ensure we have at least a few items for the loop
    let data = rawData.length > 0 ? rawData : [{ place: 'Empty', title: 'NO', title2: 'STORIES', description: '', image: '', link: '#' }];
    while(data.length < 5 && rawData.length > 0) {
        data = data.concat(rawData); // Duplicate to ensure slider works
    }
    data = data.slice(0, 6); // Keep max 6

    const _ = (id) => document.getElementById(id);
    const container = _('interactive-hero-container');
    
    const cards = data.map((i, index) => `<div class="ih-card" id="ih-card${index}" style="background-image:url('${i.image}')"></div>`).join('');
    
    const cardContents = data.map((i, index) => `
        <div class="ih-card-content" id="ih-card-content-${index}">
            <div class="ih-content-place">${i.place}</div>
            <div class="ih-content-title-1">${i.title}</div>
            <div class="ih-content-title-2">${i.title2}</div>
        </div>`).join('');

    _('ih-demo').innerHTML = cards + cardContents;

    const set = gsap.set;

    function getCard(index) { return `#ih-card${index}`; }
    function getCardContent(index) { return `#ih-card-content-${index}`; }

    let order = Array.from({length: data.length}, (_, i) => i);
    let detailsEven = true;

    let offsetTop, offsetLeft, cardWidth, cardHeight, gap;
    const ease = "sine.inOut";
    
    function calculateDimensions() {
        const isMobile = window.innerWidth < 768;
        const rect = container.getBoundingClientRect();
        
        if (isMobile) {
            cardWidth = 100;
            cardHeight = 150;
            gap = 15;
            offsetTop = rect.height - cardHeight - 80;
            offsetLeft = 20;
        } else {
            cardWidth = 160;
            cardHeight = 240;
            gap = 24;
            offsetTop = rect.height - cardHeight - 40;
            offsetLeft = rect.width - (cardWidth * 2.5); // Push to the right
        }
    }

    function init() {
        calculateDimensions();
        const [active, ...rest] = order;
        const detailsActive = detailsEven ? "#ih-details-even" : "#ih-details-odd";
        const detailsInactive = detailsEven ? "#ih-details-odd" : "#ih-details-even";

        // Setup Pagination positioning
        gsap.set("#ih-pagination", {
            top: offsetTop + cardHeight + 20,
            left: offsetLeft,
            y: 50,
            opacity: 0,
            zIndex: 60,
        });

        // Setup Active Card (Background)
        gsap.set(getCard(active), {
            x: 0,
            y: 0,
            width: '100%',
            height: '100%',
            borderRadius: 0
        });
        gsap.set(getCardContent(active), { x: 0, y: 0, opacity: 0 });
        
        // Setup Details
        gsap.set(detailsActive, { opacity: 0, zIndex: 22, x: -50 });
        gsap.set(detailsInactive, { opacity: 0, zIndex: 12 });
        gsap.set(`${detailsInactive} .ih-text`, { y: 30 });
        gsap.set(`${detailsInactive} .ih-title-1`, { y: 30 });
        gsap.set(`${detailsInactive} .ih-title-2`, { y: 30 });
        gsap.set(`${detailsInactive} .ih-desc`, { y: 30 });
        gsap.set(`${detailsInactive} .ih-cta`, { y: 30 });

        // Setup Inactive Cards
        rest.forEach((i, index) => {
            gsap.set(getCard(i), {
                x: offsetLeft + 200 + index * (cardWidth + gap),
                y: offsetTop,
                width: cardWidth,
                height: cardHeight,
                zIndex: 30,
                borderRadius: 12,
            });
            gsap.set(getCardContent(i), {
                x: offsetLeft + 200 + index * (cardWidth + gap),
                zIndex: 40,
                y: offsetTop + cardHeight - 60,
            });
        });

        const startDelay = 0.4;

        // Reveal animation
        gsap.to(".ih-cover", {
            x: container.clientWidth + 200,
            delay: 0.2,
            ease,
            duration: 0.8,
            onComplete: () => {
                _('ih-arrow-right').addEventListener('click', () => { if(clicks === 0) step(); });
            },
        });

        rest.forEach((i, index) => {
            gsap.to(getCard(i), {
                x: offsetLeft + index * (cardWidth + gap),
                zIndex: 30,
                delay: startDelay + (0.05 * index),
                ease,
            });
            gsap.to(getCardContent(i), {
                x: offsetLeft + index * (cardWidth + gap),
                zIndex: 40,
                delay: startDelay + (0.05 * index),
                ease,
            });
        });

        gsap.to("#ih-pagination", { y: 0, opacity: 1, ease, delay: startDelay });
        
        // Populate initial data
        updateDetailsContent(detailsActive, data[active]);
        gsap.to(detailsActive, { opacity: 1, x: 0, ease, delay: startDelay });
    }

    let clicks = 0;

    function updateDetailsContent(selector, itemData) {
        document.querySelector(`${selector} .ih-place-box .ih-text`).textContent = itemData.place;
        document.querySelector(`${selector} .ih-title-1`).textContent = itemData.title;
        document.querySelector(`${selector} .ih-title-2`).textContent = itemData.title2;
        document.querySelector(`${selector} .ih-desc`).textContent = itemData.description;
        document.querySelector(`${selector} .ih-discover`).setAttribute('href', itemData.link);
    }

    function step() {
        if(clicks > 0) return;
        clicks = 1;
        
        order.push(order.shift());
        detailsEven = !detailsEven;

        const detailsActive = detailsEven ? "#ih-details-even" : "#ih-details-odd";
        const detailsInactive = detailsEven ? "#ih-details-odd" : "#ih-details-even";

        updateDetailsContent(detailsActive, data[order[0]]);

        gsap.set(detailsActive, { zIndex: 22 });
        gsap.to(detailsActive, { opacity: 1, delay: 0.2, ease });
        gsap.to(`${detailsActive} .ih-text`, { y: 0, delay: 0.1, duration: 0.5, ease });
        gsap.to(`${detailsActive} .ih-title-1`, { y: 0, delay: 0.15, duration: 0.5, ease });
        gsap.to(`${detailsActive} .ih-title-2`, { y: 0, delay: 0.15, duration: 0.5, ease });
        gsap.to(`${detailsActive} .ih-desc`, { y: 0, delay: 0.2, duration: 0.4, ease });
        gsap.to(`${detailsActive} .ih-cta`, { y: 0, delay: 0.25, duration: 0.4, ease });
        
        gsap.set(detailsInactive, { zIndex: 12 });

        const [active, ...rest] = order;
        const prv = rest[rest.length - 1]; // The one that is expanding

        gsap.set(getCard(prv), { zIndex: 10 });
        gsap.set(getCard(active), { zIndex: 20 });
        
        // Expand previous to full size
        gsap.to(getCard(prv), { scale: 1.1, opacity: 0, ease, duration: 0.6 });

        gsap.to(getCardContent(active), {
            y: offsetTop + cardHeight,
            opacity: 0,
            duration: 0.3,
            ease,
        });

        // The new active card takes over the screen
        gsap.to(getCard(active), {
            x: 0,
            y: 0,
            ease,
            width: '100%',
            height: '100%',
            borderRadius: 0,
            duration: 0.6,
            onComplete: () => {
                // Reset the expanding card to the back of the line
                const xNew = offsetLeft + (rest.length - 1) * (cardWidth + gap);
                gsap.set(getCard(prv), {
                    x: xNew,
                    y: offsetTop,
                    width: cardWidth,
                    height: cardHeight,
                    zIndex: 30,
                    borderRadius: 12,
                    scale: 1,
                    opacity: 1
                });

                gsap.set(getCardContent(prv), {
                    x: xNew,
                    y: offsetTop + cardHeight - 60,
                    opacity: 1,
                    zIndex: 40,
                });

                gsap.set(detailsInactive, { opacity: 0 });
                gsap.set(`${detailsInactive} .ih-text`, { y: 30 });
                gsap.set(`${detailsInactive} .ih-title-1`, { y: 30 });
                gsap.set(`${detailsInactive} .ih-title-2`, { y: 30 });
                gsap.set(`${detailsInactive} .ih-desc`, { y: 30 });
                gsap.set(`${detailsInactive} .ih-cta`, { y: 30 });
                clicks = 0;
            },
        });

        // Shift remaining cards to the left
        rest.forEach((i, index) => {
            if (i !== prv) {
                const xNew = offsetLeft + index * (cardWidth + gap);
                gsap.set(getCard(i), { zIndex: 30 });
                gsap.to(getCard(i), {
                    x: xNew,
                    y: offsetTop,
                    width: cardWidth,
                    height: cardHeight,
                    ease,
                    duration: 0.6,
                });

                gsap.to(getCardContent(i), {
                    x: xNew,
                    y: offsetTop + cardHeight - 60,
                    opacity: 1,
                    zIndex: 40,
                    ease,
                    duration: 0.6,
                });
            }
        });
    }

    // Handle Resize
    window.addEventListener('resize', () => {
        calculateDimensions();
        // A simple reload of positions based on new dimensions
        const [active, ...rest] = order;
        gsap.set("#ih-pagination", { top: offsetTop + cardHeight + 20, left: offsetLeft });
        rest.forEach((i, index) => {
            gsap.set(getCard(i), { x: offsetLeft + index * (cardWidth + gap), y: offsetTop, width: cardWidth, height: cardHeight });
            gsap.set(getCardContent(i), { x: offsetLeft + index * (cardWidth + gap), y: offsetTop + cardHeight - 60 });
        });
    });

    init();
});
</script>
