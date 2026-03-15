<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Import Overpass Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Hero Section -->
    <div class="pt-[80px] pb-12 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="py-8">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                    <a href="/" class="hover:text-[#4F39F6] transition-colors">Home</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $category }}</span>
                </div>

                <!-- Title & Description -->
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3" style="font-family: 'Overpass', sans-serif;">{{ $category }}</h1>
                        <p class="text-lg text-gray-600">Explore our premium collection of {{ strtolower($category) }} for men</p>
                    </div>
                    
                    <!-- Category Icon -->
                    <div class="hidden md:block">
                        <div class="w-16 h-16 bg-[#4F39F6]/10 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-8 py-8">
        @if($products->count() > 0)
        <!-- Results Count & Filters -->
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-gray-700 font-medium">
                    Showing <span class="text-[#4F39F6] font-bold">{{ $products->count() }}</span> products
                </p>
            </div>
            
            <!-- Sort/Filter Options (placeholder for future enhancement) -->
            <div class="flex gap-3">
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:border-[#4F39F6] hover:text-[#4F39F6] transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                    </svg>
                    <span class="hidden sm:inline">Sort</span>
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:border-[#4F39F6] hover:text-[#4F39F6] transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <span class="hidden sm:inline">Filter</span>
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
            @foreach($products as $product)
            <div wire:key="product-{{ $product->id }}" class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-[#4F39F6]/20">
                <!-- Product Image -->
                <div class="relative aspect-square bg-gray-100 overflow-hidden">
                    @if($product->image_groups && $product->image_groups->image_1)
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
                    
                    <!-- Stock Badge -->
                    @if(isset($product->quantity))
                        @if($product->quantity > 0)
                        <div class="absolute top-3 left-3 px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg">
                            In Stock
                        </div>
                        @else
                        <div class="absolute top-3 left-3 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">
                            Out of Stock
                        </div>
                        @endif
                    @endif

                    <!-- Wishlist Button -->
                    <button wire:click="toggleWishlist({{ $product->id }})" 
                        class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm hover:bg-white rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110 group/wishlist z-10">
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
                            class="bg-white text-gray-900 font-semibold px-6 py-3 rounded-xl shadow-xl hover:bg-[#4F39F6] hover:text-white transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 flex items-center gap-2">
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
                            class="flex-1 bg-[#4F39F6] text-white font-semibold py-2 px-3 rounded-lg shadow-lg hover:bg-[#3d2bc4] transition-all duration-200 flex items-center justify-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Add to Cart
                        </button>
                        <button wire:click="quickView({{ $product->id }})"
                            class="flex-1 bg-white text-gray-900 font-semibold py-2 px-3 rounded-lg shadow-lg hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-1 text-sm">
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
                    <!-- Category/Subcategory -->
                    <div class="mb-2">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                            {{ $product->subcategory ?? ucfirst($product->category) }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 min-h-[3.5rem] group-hover:text-[#4F39F6] transition-colors">
                        {{ $product->name }}
                    </h3>
                    
                    <!-- Price & Rating -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-2xl font-bold text-[#4F39F6]">GHS {{ number_format($product->price, 2) }}</p>
                        </div>
                        <div class="flex items-center gap-1 bg-yellow-50 px-2 py-1 rounded-lg">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">4.5</span>
                        </div>
                    </div>

                    <!-- Colors Preview -->
                    @if($product->colors && count($product->colors) > 0)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">Colors:</span>
                            <div class="flex gap-1">
                                @foreach(array_slice($product->colors, 0, 4) as $color)
                                <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm" 
                                     style="background-color: {{ $color }}"
                                     title="{{ ucfirst($color) }}"></div>
                                @endforeach
                                @if(count($product->colors) > 4)
                                <div class="w-5 h-5 rounded-full bg-gray-200 border-2 border-white shadow-sm flex items-center justify-center">
                                    <span class="text-[10px] font-semibold text-gray-600">+{{ count($product->colors) - 4 }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $products->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg p-16 text-center">
            <div class="w-32 h-32 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Products Found</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">We're working on adding more {{ strtolower($category) }} products soon. Check back later or explore other categories!</p>
            <a href="/" class="inline-flex items-center gap-2 px-8 py-4 bg-[#4F39F6] text-white rounded-xl hover:bg-[#3d2bc4] transition-colors font-semibold shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>
        @endif
    </div>
</div>
