<div id="trending-section" class="py-16 bg-white">
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-3 mb-4">
                <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">Trending Now</h2>
            </div>
            <p class="text-lg text-gray-600">Discover what's hot this season</p>
        </div>

        <!-- Category Tabs -->
        <div class="flex justify-center mb-12">
            @php
                $tabs = [
                    'clothing' => ['name' => 'Clothing', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                    'footwear' => ['name' => 'Footwear', 'icon' => 'M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4z'],
                    'accessories' => ['name' => 'Accessories', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                   
                    'grooming' => ['name' => 'Grooming', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z']
                ];
            @endphp
            
            <!-- Desktop Tabs -->
            <nav class="hidden md:inline-flex bg-gray-100 rounded-2xl p-1.5 shadow-sm">
                @foreach ($tabs as $key => $tab)
                    <button wire:click="setActiveTab('{{ $key }}')"
                        class="group px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200 flex items-center gap-2 cursor-pointer
                        {{ $active_tab === $key 
                            ? 'bg-[#4F39F6] text-white shadow-lg' 
                            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-200' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"></path>
                        </svg>
                        <span>{{ $tab['name'] }}</span>
                    </button>
                @endforeach
            </nav>

            <!-- Mobile Dropdown -->
            <div class="md:hidden w-full max-w-xs mx-auto relative" x-data="{ open: false }">
                <button @click="open = !open" 
                    class="w-full bg-gray-100 rounded-2xl p-4 shadow-sm flex items-center justify-between cursor-pointer">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tabs[$active_tab]['icon'] }}"></path>
                        </svg>
                        <span class="font-semibold text-gray-800">{{ $tabs[$active_tab]['name'] }}</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-600 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute left-0 right-0 z-10 mt-2 bg-white rounded-2xl shadow-xl border border-gray-200 py-2"
                     style="display: none;">
                    @foreach ($tabs as $key => $tab)
                        <button wire:click="setActiveTab('{{ $key }}')" @click="open = false"
                            class="w-full text-left px-4 py-3 font-semibold transition-colors flex items-center gap-3 cursor-pointer
                            {{ $active_tab === $key 
                                ? 'bg-[#4F39F6]/10 text-[#4F39F6]' 
                                : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"></path>
                            </svg>
                            {{ $tab['name'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Products Horizontal Scroll -->
        @if($trending_products->count() > 0)
        <div class="relative mb-12">
            <!-- Scroll Container -->
            <div class="overflow-x-auto scrollbar-hide pb-4 -mx-4 px-4 md:mx-0 md:px-0">
                <div class="flex gap-6 min-w-max">
                    @foreach ($trending_products as $product)
                        <div wire:key="product-{{ $product->id }}"
                            class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-[#4F39F6]/20 w-[280px] flex-shrink-0">
                            <!-- Product Image -->
                            <div class="relative aspect-square bg-gray-100 overflow-hidden">
                                @if ($product->image_groups && $product->image_groups->image_1)
                                    <img src="{{ asset('storage/' . $product->image_groups->image_1) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Trending Badge -->
                                <div class="absolute top-3 left-3 px-3 py-1 bg-gradient-to-r from-[#4F39F6] to-[#6B5FFF] text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Trending
                                </div>

                                <!-- Wishlist Button -->
                                <button wire:click="toggleWishlist({{ $product->id }})" 
                                    class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110 group/wishlist cursor-pointer">
                                    @if(in_array($product->id, $wishlistProductIds))
                                        <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-700 group-hover/wishlist:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    @endif
                                </button>
                                
                                <!-- Desktop Quick View Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-6 hidden md:flex">
                                    <button wire:click="viewProduct({{ $product->id }})"
                                        class="bg-white text-gray-900 font-semibold px-6 py-3 rounded-xl shadow-xl hover:bg-[#4F39F6] hover:text-white transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 flex items-center gap-2 cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Quick View
                                    </button>
                                </div>

                                <!-- Mobile Action Buttons -->
                                <div class="absolute bottom-3 left-3 right-3 flex gap-2 md:hidden">
                                    <button wire:click="addToCart({{ $product->id }})"
                                        class="flex-1 bg-[#4F39F6] text-white font-semibold py-2 px-3 rounded-lg shadow-lg hover:bg-[#3d2bc4] transition-all duration-200 flex items-center justify-center gap-1 text-sm cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                    <button wire:click="quickView({{ $product->id }})"
                                        class="flex-1 bg-white text-gray-900 font-semibold py-2 px-3 rounded-lg shadow-lg hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-1 text-sm cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Quick View
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-5">
                                <div class="mb-2">
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        {{ $product->subcategory ?? ucfirst($product->category) }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 min-h-[3.5rem] group-hover:text-[#4F39F6] transition-colors">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-center justify-between">
                                    <p class="text-2xl font-bold text-[#4F39F6]">GHS {{ number_format($product->price, 2) }}</p>
                                    <div class="flex items-center gap-1 bg-yellow-50 px-2 py-1 rounded-lg">
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700">4.5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Scroll Hint -->
            <div class="flex justify-center mt-4 md:hidden">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    <span>Swipe to see more</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center">
            <a href="{{ route(strtolower($active_tab)) }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-[#4F39F6] text-white rounded-xl hover:bg-[#3d2bc4] transition-colors font-semibold shadow-lg hover:shadow-xl cursor-pointer">
                <span>View All {{ ucfirst($active_tab) }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Trending Products</h3>
            <p class="text-gray-600 mb-8">Check back soon for trending items in this category!</p>
        </div>
        @endif
    </div>
</div>
