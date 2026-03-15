<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 pt-[80px] pb-12">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-[#4F39F6]/10 rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">My Wishlist</h1>
                    </div>
                    <p class="text-gray-600 text-lg">
                        <span class="font-semibold text-[#4F39F6]">{{ count($wishlists) }}</span> 
                        {{ count($wishlists) === 1 ? 'item' : 'items' }} saved for later
                    </p>
                </div>
                
                @if(count($wishlists) > 0)
                <div class="flex gap-3">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl hover:border-[#4F39F6] hover:text-[#4F39F6] transition-all font-semibold shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Continue Shopping</span>
                    </a>
                </div>
                @endif
            </div>
        </div>

        @if(count($wishlists) === 0)
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-xl p-16 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-[#4F39F6]/10 to-[#4F39F6]/5 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-3">Your Wishlist is Empty</h3>
                    <p class="text-gray-600 text-lg mb-8">Save your favorite items here and never lose track of what you love!</p>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 px-8 py-4 bg-[#4F39F6] text-white rounded-xl hover:bg-[#3d2bc4] transition-colors font-semibold shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Start Shopping</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlists as $wishlist)
                <div wire:key="wishlist-{{ $wishlist->id }}" 
                     class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-[#4F39F6]/20 group">
                    <!-- Product Image -->
                    <div class="relative aspect-square bg-gray-100 overflow-hidden">
                        @if($wishlist->product->image_groups && $wishlist->product->image_groups->image_1)
                        <a href="{{ route('product_details', $wishlist->product->id) }}">
                            <img src="{{ asset('storage/' . $wishlist->product->image_groups->image_1) }}" 
                                 alt="{{ $wishlist->product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </a>
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <!-- Stock Badge -->
                        @if($wishlist->product->quantity > 0)
                        <div class="absolute top-3 left-3 px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg">
                            In Stock
                        </div>
                        @else
                        <div class="absolute top-3 left-3 px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">
                            Out of Stock
                        </div>
                        @endif

                        <!-- Remove Button -->
                        <button wire:click="removeFromWishlist({{ $wishlist->id }})" 
                                class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm hover:bg-red-500 rounded-full flex items-center justify-center text-gray-700 hover:text-white transition-all shadow-lg hover:scale-110 z-10">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        
                        <!-- Desktop Quick View Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-4 hidden md:flex">
                            <button wire:click="viewProduct({{ $wishlist->product->id }})"
                                class="bg-white text-gray-900 font-semibold px-5 py-2.5 rounded-xl shadow-xl hover:bg-[#4F39F6] hover:text-white transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Quick View
                            </button>
                        </div>

                        <!-- Mobile Quick View Button -->
                        <div class="absolute bottom-3 left-3 right-3 md:hidden">
                            <button wire:click="quickView({{ $wishlist->product->id }})"
                                class="w-full bg-white text-gray-900 font-semibold py-2 px-3 rounded-lg shadow-lg hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-1 text-sm">
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
                                {{ $wishlist->product->subcategory ?? ucfirst($wishlist->product->category) }}
                            </span>
                            @if($wishlist->product->brand)
                            <span class="text-xs text-gray-400"> • {{ $wishlist->product->brand }}</span>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <a href="{{ route('product_details', $wishlist->product->id) }}" 
                           class="block font-bold text-lg text-gray-900 mb-3 line-clamp-2 min-h-[3.5rem] hover:text-[#4F39F6] transition-colors">
                            {{ $wishlist->product->name }}
                        </a>
                        
                        <!-- Price -->
                        <div class="mb-4">
                            <p class="text-2xl font-bold text-[#4F39F6]">GHS {{ number_format($wishlist->product->price, 2) }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            @if($wishlist->product->quantity > 0)
                            <button wire:click="addToCart({{ $wishlist->product->id }})"
                                    class="flex-1 px-4 py-3 bg-[#4F39F6] text-white rounded-xl hover:bg-[#3d2bc4] transition-colors font-semibold text-sm flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Add to Cart</span>
                            </button>
                            @else
                            <button disabled
                                    class="flex-1 px-4 py-3 bg-gray-300 text-gray-500 rounded-xl cursor-not-allowed font-semibold text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Out of Stock</span>
                            </button>
                            @endif
                        </div>

                        <!-- Colors Preview -->
                        @if($wishlist->product->colors && count($wishlist->product->colors) > 0)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">Colors:</span>
                                <div class="flex gap-1">
                                    @foreach(array_slice($wishlist->product->colors, 0, 5) as $color)
                                    <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200" 
                                         style="background-color: {{ $color }}"
                                         title="{{ ucfirst($color) }}"></div>
                                    @endforeach
                                    @if(count($wishlist->product->colors) > 5)
                                    <div class="w-5 h-5 rounded-full bg-gray-200 border-2 border-white shadow-sm flex items-center justify-center">
                                        <span class="text-[10px] font-semibold text-gray-600">+{{ count($wishlist->product->colors) - 5 }}</span>
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

            <!-- Bottom Actions -->
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 bg-white rounded-2xl p-6 shadow-lg">
                <div class="text-center sm:text-left">
                    <p class="text-gray-600">
                        Found something you like? 
                        <span class="font-semibold text-gray-900">Add items to your cart to checkout!</span>
                    </p>
                </div>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#4F39F6] text-white rounded-xl hover:bg-[#3d2bc4] transition-colors font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Discover More</span>
                </a>
            </div>
        @endif
    </div>
</div>
