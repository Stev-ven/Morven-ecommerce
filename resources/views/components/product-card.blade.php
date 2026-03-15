@props(['page_content'])

@php
    $slides = $page_content['main_product_cards']->map(function ($p){
        return [
            'title' => $p->title,
            'description'  => $p->description,
            'image_path'  => asset($p->image_path),
        ];
    })->values();
@endphp

<div
    x-data='{
        slides: @json($slides),
        currentIndex: 0,
        autoplayInterval: null,
        next() { this.currentIndex = (this.currentIndex + 1) % this.slides.length },
        prev() { this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length },
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.next();
            }, 5000);
        },
        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
            }
        }
    }'
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    class="relative w-[95%] mx-auto rounded-2xl card mt-[65px] h-[50vh] md:h-[85vh] overflow-hidden bg-gray-200" 
    >

    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="currentIndex === index" 
            x-transition:enter="transition ease-in-out duration-1000"
            x-transition:enter-start="opacity-0 transform scale-105"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in-out duration-1000"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute inset-0">
            <img :src="slide.image_path" alt="" class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white px-4">
                <h1 
                    class="text-3xl md:text-5xl font-bold"
                    x-show="currentIndex === index"
                    x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-text="slide.title">
                </h1>
                <p 
                    class="mt-2 text-lg md:text-xl max-w-xl"
                    x-show="currentIndex === index"
                    x-transition:enter="transition ease-out duration-700 delay-500"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-text="slide.description">
                </p>
                <button
                    x-show="currentIndex === index"
                    x-transition:enter="transition ease-out duration-700 delay-700"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    @click="document.getElementById('trending-section').scrollIntoView({ behavior: 'smooth', block: 'start' })"
                    class="mt-8 px-8 py-4 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white font-semibold rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    <span>Start Shopping</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </button>
            </div>
        </div>
    </template>

    <button @click="prev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full p-3 shadow-lg transition-all hover:scale-110 z-10">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button @click="next" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full p-3 shadow-lg transition-all hover:scale-110 z-10">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
        <template x-for="(slide, index) in slides" :key="index">
            <button 
                @click="currentIndex = index; stopAutoplay(); startAutoplay();"
                class="transition-all duration-300"
                :class="currentIndex === index ? 'w-8 h-3 bg-white rounded-full' : 'w-3 h-3 bg-white/50 hover:bg-white/75 rounded-full'">
            </button>
        </template>
    </div>
</div>