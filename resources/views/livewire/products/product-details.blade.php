<div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-8">
    <!-- Import Overpass Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Navigation -->
        <div class="mb-6">
            <button onclick="history.back()" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium">Back</span>
            </button>
        </div>

        <!-- Product Details Section -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 lg:p-8">
                <!-- Product Images -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                        @if($product->image_groups && $product->image_groups->image_1)
                        <img src="{{ asset('storage/' . $product->image_groups->image_1) }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Thumbnail Images -->
                    @if($product->image_groups)
                    <div class="grid grid-cols-4 gap-3">
                        @for($i = 1; $i <= 4; $i++)
                            @php $imageField = "image_$i"; @endphp
                            @if($product->image_groups->$imageField)
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-[#4F39F6] transition-all">
                                <img src="{{ asset('storage/' . $product->image_groups->$imageField) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                            @endif
                        @endfor
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Category & Brand -->
                    <div class="flex items-center gap-3 text-sm">
                        <span class="px-3 py-1 bg-[#4F39F6]/10 text-[#4F39F6] rounded-full font-medium">
                            {{ ucfirst($product->category) }}
                        </span>
                        @if($product->subcategory)
                        <span class="text-gray-500">{{ $product->subcategory }}</span>
                        @endif
                        @if($product->brand)
                        <span class="text-gray-500">•</span>
                        <span class="text-gray-700 font-medium">{{ $product->brand }}</span>
                        @endif
                    </div>
                </div>

                

                    <!-- Product Name -->
                    <div class="w-full flex justify-between">
                        <div>
                            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Overpass', sans-serif;">{{ $product->name }}</h1>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-[#4F39F6]" style="font-family: 'Overpass', sans-serif;">GHS {{ $product->price == floor($product->price) ? number_format($product->price, 0) : number_format($product->price, 2) }}</span>
                            
                        </div>
                        
                        
                        
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Colors -->
                    @if($product->colors && count($product->colors) > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-3 uppercase tracking-wide">
                            Color
                            @if($selectedColor)
                                <span class="text-[#4F39F6] font-normal normal-case">- {{ ucfirst($selectedColor) }}</span>
                            @endif
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->colors as $color)
                                <button 
                                    wire:click="selectColor('{{ $color }}')"
                                    class="group relative flex items-center gap-2 px-3 py-2 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $selectedColor === $color ? 'border-[#4F39F6] bg-[#4F39F6]/5 shadow-md' : 'border-gray-300 hover:border-gray-400' }}">
                                    <div class="w-5 h-5 rounded-full border-2 border-white shadow-md" 
                                         style="background-color: {{ $color }}"></div>
                                    <span class="text-sm font-medium {{ $selectedColor === $color ? 'text-[#4F39F6]' : 'text-gray-700' }} capitalize">
                                        {{ $color }}
                                    </span>
                                    @if($selectedColor === $color)
                                        <svg class="w-4 h-4 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Sizes -->
                    @if($product->sizes && count($product->sizes) > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-3 uppercase tracking-wide">
                            Size
                            @if($selectedSize)
                                <span class="text-[#4F39F6] font-normal normal-case">- {{ $selectedSize }}</span>
                            @endif
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->sizes as $size)
                                <button 
                                    wire:click="selectSize('{{ $size }}')"
                                    class="min-w-[50px] px-4 py-2 border-2 rounded-lg text-sm font-semibold transition-all duration-200 hover:shadow-md {{ $selectedSize === $size ? 'border-[#4F39F6] bg-[#4F39F6] text-white shadow-md' : 'border-gray-300 text-gray-700 hover:border-gray-400' }}">
                                    {{ strtoupper($size) }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quantity Selector -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-3 uppercase tracking-wide">
                            Quantity
                            @if($product->quantity > 0)
                                <span class="text-gray-500 font-normal normal-case text-xs">(Max: {{ $product->quantity }})</span>
                            @endif
                        </h3>
                        <div class="flex items-center gap-3">
                            <button 
                                wire:click="decrementQuantity"
                                {{ $quantity <= 1 ? 'disabled' : '' }}
                                class="w-10 h-10 flex items-center justify-center border-2 rounded-lg transition-all {{ $quantity <= 1 ? 'border-gray-200 text-gray-300 cursor-not-allowed' : 'border-gray-300 hover:border-[#4F39F6] hover:bg-[#4F39F6]/5 hover:text-[#4F39F6] cursor-pointer' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <div class="w-16 h-10 flex items-center justify-center border-2 border-gray-300 rounded-lg font-bold text-lg bg-gray-50">
                                {{ $quantity }}
                            </div>
                            <button 
                                wire:click="incrementQuantity"
                                {{ $quantity >= $product->quantity ? 'disabled' : '' }}
                                class="w-10 h-10 flex items-center justify-center border-2 rounded-lg transition-all {{ $quantity >= $product->quantity ? 'border-gray-200 text-gray-300 cursor-not-allowed' : 'border-gray-300 hover:border-[#4F39F6] hover:bg-[#4F39F6]/5 hover:text-[#4F39F6] cursor-pointer' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                        @if($quantity >= $product->quantity && $product->quantity > 0)
                            <p class="text-xs text-amber-600 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Maximum quantity reached
                            </p>
                        @endif
                    </div>

                    <!-- Add to Cart Button -->
                    <div class="pt-4 space-y-3">
                        <button wire:click="addToCart"
                                class="w-full px-8 py-4 bg-[#4F39F6] text-white rounded-xl hover:bg-[#3d2bc4] transition-colors font-semibold text-lg flex items-center justify-center gap-3 shadow-lg hover:shadow-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>{{ $isInCart ? 'Update Cart' : 'Add To Cart' }}</span>
                        </button>
                        
                        @if($isInCart)
                        <button wire:click="removeFromCart"
                                class="w-full px-8 py-4 bg-white text-gray-700 border-2 border-gray-300 rounded-xl hover:border-red-500 hover:bg-red-50 hover:text-red-600 transition-all font-semibold text-lg flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Remove from Cart</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">Related Products</h2>
                <a href="{{ route(strtolower($product->category)) }}" class="text-[#4F39F6] hover:text-[#3d2bc4] font-medium flex items-center gap-2">
                    <span>View All</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300">
                    <div class="relative aspect-square bg-gray-100 overflow-hidden">
                        @if($relatedProduct->image_groups && $relatedProduct->image_groups->image_1)
                        <img src="{{ asset('storage/' . $relatedProduct->image_groups->image_1) }}" 
                             alt="{{ $relatedProduct->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <!-- Quick View Overlay -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <a href="{{ route('product_details', $relatedProduct->id) }}"
                                    class="bg-white text-gray-900 font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-[#4F39F6] hover:text-white transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>View Details</span>
                            </a>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="mb-2">
                            <span class="text-xs text-gray-500 uppercase">{{ ucfirst($relatedProduct->category) }}</span>
                            @if($relatedProduct->brand)
                            <span class="text-xs text-gray-400"> • {{ $relatedProduct->brand }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product_details', $relatedProduct->id) }}" 
                           class="block font-semibold text-gray-900 hover:text-[#4F39F6] transition-colors mb-2 line-clamp-2">
                            {{ $relatedProduct->name }}
                        </a>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-[#4F39F6]">GHS {{ number_format($relatedProduct->price, 2) }}</span>
                            @if($relatedProduct->quantity > 0)
                            <span class="text-xs text-green-600 font-medium">In Stock</span>
                            @else
                            <span class="text-xs text-red-600 font-medium">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
