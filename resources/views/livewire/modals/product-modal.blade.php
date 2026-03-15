<div class="flex flex-col lg:flex-row h-full max-h-[95vh]">
    <!-- Import Overpass Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Product Image Section -->
    <div class="w-full lg:w-[45%] bg-gradient-to-br from-gray-50 to-gray-100 p-3 sm:p-4 lg:p-8 flex flex-col">
        <!-- Main Image -->
        <div class="flex-1 flex items-center justify-center mb-2 sm:mb-3 lg:mb-4">
            <div class="w-full aspect-square rounded-lg sm:rounded-xl lg:rounded-2xl overflow-hidden shadow-lg bg-white">
                <img src="{{ asset('storage/' . $product['image_groups']['image_1']) }}" 
                     alt="{{ $product['name'] }}"
                     class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Thumbnail Images -->
        @if(isset($product['image_groups']))
        <div class="grid grid-cols-4 gap-1.5 sm:gap-2 lg:gap-3">
            @for($i = 1; $i <= 4; $i++)
                @php $imageField = "image_$i"; @endphp
                @if(isset($product['image_groups'][$imageField]) && $product['image_groups'][$imageField])
                <div class="aspect-square rounded-md sm:rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-[#4F39F6] transition-all shadow-md bg-white">
                    <img src="{{ asset('storage/' . $product['image_groups'][$imageField]) }}" 
                         alt="{{ $product['name'] }}"
                         class="w-full h-full object-cover">
                </div>
                @endif
            @endfor
        </div>
        @endif
    </div>

    <!-- Product Details Section -->
    <div class="w-full lg:w-[55%] bg-white flex flex-col max-h-[95vh] lg:max-h-none">
        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-3 sm:p-4 lg:p-8 pb-24 sm:pb-28 lg:pb-8">
            <div class="max-w-2xl">
                <!-- Category & Brand Badge -->
                <div class="flex items-center gap-1.5 sm:gap-2 mb-2 sm:mb-3 lg:mb-4 flex-wrap">
                    <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-[#4F39F6]/10 text-[#4F39F6] rounded-full text-xs sm:text-sm font-semibold">
                        {{ ucfirst($product['category']) }}
                    </span>
                    @if(isset($product['subcategory']) && $product['subcategory'])
                    <span class="text-gray-400 text-xs sm:text-sm">•</span>
                    <span class="text-xs sm:text-sm text-gray-600">{{ $product['subcategory'] }}</span>
                    @endif
                    @if(isset($product['brand']) && $product['brand'])
                    <span class="text-gray-400 text-xs sm:text-sm">•</span>
                    <span class="text-xs sm:text-sm font-medium text-gray-700">{{ $product['brand'] }}</span>
                    @endif
                </div>

                <!-- name, price and stock status -->
                <div class="w-full flex justify-between">
                    <!-- Product Name -->
                    <h2 class="text-sm sm:text-xl lg:text-3xl font-bold text-gray-900 mb-2 sm:mb-3 lg:mb-4 leading-tight" style="font-family: 'Overpass', sans-serif;">
                        {{ ucfirst($product['name']) }}
                    </h2>

                    <!-- Price -->
                    <div class="flex items-baseline gap-2 sm:gap-3 mb-3 sm:mb-4 lg:mb-6 flex-wrap">
                        <p class="text-sm sm:text-2xl lg:text-3xl font-bold text-[#4F39F6]" style="font-family: 'Overpass', sans-serif;">GHS {{ $product['price'] == floor($product['price']) ? number_format($product['price'], 0) : number_format($product['price'], 2) }}</p>
                        @if(isset($product['old_price']) && $product['old_price'] > $product['price'])
                            <p class="text-sm sm:text-base lg:text-lg text-gray-400 line-through" style="font-family: 'Overpass', sans-serif;">GHS {{ $product['old_price'] == floor($product['old_price']) ? number_format($product['old_price'], 0) : number_format($product['old_price'], 2) }}</p>
                            <span class="px-1.5 sm:px-2 py-0.5 sm:py-1 bg-red-100 text-red-600 rounded-md text-xs sm:text-sm font-semibold">
                                -{{ round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) }}%
                            </span>
                        @endif
                    </div>


                     <!-- Stock Status -->
                    <div class="mb-3 sm:mb-4 lg:mb-6">
                        @if(isset($product['quantity']) && $product['quantity'] > 0)
                        <div class="flex items-center gap-1.5 sm:gap-2 text-green-600">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-xs sm:text-sm lg:text-base" style="font-family: 'Overpass', sans-serif;">In Stock ({{ $product['quantity'] }} available)</span>
                        </div>
                        @else
                        <div class="flex items-center gap-1.5 sm:gap-2 text-red-600">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-xs sm:text-sm lg:text-base" style="font-family: 'Overpass', sans-serif;">Out of Stock</span>
                        </div>
                        @endif
                    </div>
                </div>

                

                

               

                <!-- Product Description -->
                @if(isset($product['description']))
                <div class="mb-3 sm:mb-4 lg:mb-6 pb-3 sm:pb-4 lg:pb-6 border-b border-gray-200">
                    <h3 class="text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2 uppercase tracking-wide">Description</h3>
                    <p class="text-xs sm:text-sm lg:text-base text-gray-600 leading-relaxed">{{ $product['description'] }}</p>
                </div>
                @endif

                <!-- color and size selection -->
                 <div class="w-full flex overflow-x-scroll space-x-12">

                     <!-- Color Selection -->
                    @if(!empty($product['colors']))
                    <div class="mb-3 sm:mb-4 lg:mb-6">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-900 mb-2 sm:mb-3 uppercase tracking-wide">
                            Color
                            @if($selectedColor)
                                <span class="text-[#4F39F6] font-normal normal-case">- {{ ucfirst($selectedColor) }}</span>
                            @endif
                        </label>
                        <div class="flex flex-wrap gap-1.5 sm:gap-2 lg:gap-3">
                            @foreach ($product['colors'] as $color)
                                <button 
                                    wire:click="selectColor('{{ $color }}')"
                                    class="group relative flex items-center gap-1.5 sm:gap-2 px-2 sm:px-3 lg:px-4 py-2 sm:py-2.5 lg:py-3 border-2 rounded-lg sm:rounded-xl transition-all duration-200 hover:shadow-md {{ $selectedColor === $color ? 'border-[#4F39F6] bg-[#4F39F6]/5 shadow-md' : 'border-gray-300 hover:border-gray-400' }}">
                                    <div class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 rounded-full border-2 border-white shadow-md" 
                                        style="background-color: {{ $color }}"></div>
                                    <span class="text-xs sm:text-sm font-medium {{ $selectedColor === $color ? 'text-[#4F39F6]' : 'text-gray-700' }}">
                                        {{ ucfirst($color) }}
                                    </span>
                                    @if($selectedColor === $color)
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Size Selection -->
                    @if(!empty($product['sizes']))
                    <div class="mb-3 sm:mb-4 lg:mb-6">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-900 mb-2 sm:mb-3 uppercase tracking-wide">
                            Size
                            @if($selectedSize)
                                <span class="text-[#4F39F6] font-normal normal-case">- {{ $selectedSize }}</span>
                            @endif
                        </label>
                        <div class="flex flex-wrap gap-1.5 sm:gap-2">
                            @foreach ($product['sizes'] as $size)
                                <button 
                                    wire:click="selectSize('{{ $size }}')"
                                    class="min-w-[50px] sm:min-w-[60px] px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 lg:py-3 border-2 rounded-lg sm:rounded-xl text-xs sm:text-sm lg:text-base font-semibold transition-all duration-200 hover:shadow-md {{ $selectedSize === $size ? 'border-[#4F39F6] bg-[#4F39F6] text-white shadow-md' : 'border-gray-300 text-gray-700 hover:border-gray-400' }}">
                                    {{ strtoupper($size) }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

               </div>

               

                <!-- Quantity Selector -->
                <div class="mb-4 sm:mb-6 lg:mb-8">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-900 mb-2 sm:mb-3 uppercase tracking-wide">
                        Quantity
                        @if(isset($product['quantity']) && $product['quantity'] > 0)
                            <span class="text-gray-500 font-normal normal-case text-xs">(Max: {{ $product['quantity'] }})</span>
                        @endif
                    </label>
                    <div class="flex items-center gap-2 sm:gap-3 lg:gap-4">
                        <button 
                            wire:click="decrementQuantity"
                            {{ $quantity <= 1 ? 'disabled' : '' }}
                            class="w-10 h-10 sm:w-11 sm:h-11 lg:w-12 lg:h-12 flex items-center justify-center border-2 rounded-lg sm:rounded-xl transition-all {{ $quantity <= 1 ? 'border-gray-200 text-gray-300 cursor-not-allowed' : 'border-gray-300 hover:border-[#4F39F6] hover:bg-[#4F39F6]/5 hover:text-[#4F39F6] cursor-pointer' }}">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <div class="w-16 h-10 sm:w-18 sm:h-11 lg:w-20 lg:h-12 flex items-center justify-center border-2 border-gray-300 rounded-lg sm:rounded-xl font-bold text-lg sm:text-xl bg-gray-50">
                            {{ $quantity }}
                        </div>
                        <button 
                            wire:click="incrementQuantity"
                            {{ $quantity >= ($product['quantity'] ?? 0) ? 'disabled' : '' }}
                            class="w-10 h-10 sm:w-11 sm:h-11 lg:w-12 lg:h-12 flex items-center justify-center border-2 rounded-lg sm:rounded-xl transition-all {{ $quantity >= ($product['quantity'] ?? 0) ? 'border-gray-200 text-gray-300 cursor-not-allowed' : 'border-gray-300 hover:border-[#4F39F6] hover:bg-[#4F39F6]/5 hover:text-[#4F39F6] cursor-pointer' }}">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    @if($quantity >= ($product['quantity'] ?? 0) && ($product['quantity'] ?? 0) > 0)
                        <p class="text-xs text-amber-600 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Maximum quantity reached
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sticky Action Buttons (Mobile) / Normal (Desktop) -->
        <div class="fixed lg:relative bottom-0 left-0 right-0 bg-white border-t border-gray-200 lg:border-t-0 p-3 sm:p-4 lg:p-6 lg:pt-0 shadow-lg lg:shadow-none z-10">
            <div class="max-w-2xl mx-auto space-y-2 sm:space-y-3">
                <button
                    class="w-full h-11 sm:h-12 lg:h-14 bg-[#4F39F6] text-white flex items-center justify-center gap-2 sm:gap-3 rounded-lg sm:rounded-xl cursor-pointer hover:bg-[#3d2bc4] transition-all duration-200 font-bold text-sm sm:text-base lg:text-lg shadow-lg hover:shadow-xl"
                    wire:click='addToCart()'>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>{{ $isInCart ? 'Update Cart' : 'Add To Cart' }}</span>
                </button>
                
                @if($isInCart)
                <button
                    class="w-full h-11 sm:h-12 lg:h-14 bg-white text-gray-700 border-2 border-gray-300 flex items-center justify-center gap-2 sm:gap-3 rounded-lg sm:rounded-xl cursor-pointer hover:border-red-500 hover:bg-red-50 hover:text-red-600 transition-all duration-200 font-semibold text-sm sm:text-base"
                    wire:click='removeFromCart()'>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Remove from Cart</span>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
