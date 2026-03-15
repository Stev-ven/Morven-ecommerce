<div class="w-full h-full overflow-x-hidden overflow-y-auto custom-scrollbar pt-2 flex flex-col">
    <div class="cart-header px-2 pb-4 border-b-2 border-gray-200 mb-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#4F39F6] p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="cart-title font-bold text-gray-800 text-xl">My Cart</h1>
                <p class="text-sm text-gray-500">{{ count($cartItems) }} {{ count($cartItems) === 1 ? 'Item' : 'Items' }}</p>
            </div>
        </div>
    </div>
    <div class="items-list flex flex-col mt-5 border-gray-200 border-b px-2">
        @foreach ($cartItems as $cartKey => $item)
            <div class="item flex pb-3 mb-3">
                <div
                    class="item-image w-[150px] h-[120px] md:w-[150px] md:h-[150px] border border-gray-200 rounded-xl mr-3 overflow-hidden flex-shrink-0">
                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                        class="w-full h-full object-cover">
                </div>
                <div class="ml-2 description flex flex-col flex-1 min-w-0">
                    <div class="item-name font-semibold text-base md:text-lg truncate pb-2">
                        {{ $item['name'] }}
                    </div>
                    <div class="price pb-2">
                        <h1 class="text-gray-700 text-sm font-medium">
                            GHS {{ number_format($item['price'], 2) }}
                        </h1>
                    </div>
                    @if (isset($item['color']) && $item['color'])
                        <div class="color pb-1">
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                                Color: {{ is_array($item['color']) ? implode(', ', $item['color']) : $item['color'] }}
                            </span>
                        </div>
                    @endif
                    @if (isset($item['size']) && $item['size'])
                        <div class="size pb-1">
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                                Size: {{ is_array($item['size']) ? implode(', ', $item['size']) : $item['size'] }}
                            </span>
                        </div>
                    @endif

                    <div class="qty pb-2">
                        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                            Qty: {{ $item['qty'] }}
                        </span>
                    </div>
                    
                    <div class="remove group mt-auto">
                        <button class="cursor-pointer flex items-center gap-1" wire:click='removeFromCart("{{ $cartKey }}")'>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="text-gray-500 text-sm group-hover:text-red-500 transition-colors">Remove</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if (count($cartItems) > 0)
        <div class="w-full cart-footer flex flex-col md:flex-row gap-3 p-4 mt-auto">
            <button
                class="flex-1 px-4 py-3 bg-white hover:bg-gray-50 cursor-pointer border-2 border-gray-300 hover:border-[#4F39F6] rounded-lg font-medium text-gray-700 hover:text-[#4F39F6] transition-all flex items-center justify-center gap-2"
                wire:click="viewCart()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>View & Edit</span>
            </button>
            <button 
                class="flex-1 px-4 py-3 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] cursor-pointer font-medium transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                wire:click="viewCart()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Checkout</span>
            </button>
        </div>
    @endif
</div>
