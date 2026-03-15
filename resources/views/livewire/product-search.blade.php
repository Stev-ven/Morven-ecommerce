<div>
    <!-- Search Input -->
    <div class="search relative w-full">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"
            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
        </svg>
        <input type="text" 
               wire:model.live.debounce.300ms="search"
               placeholder="Search for clothing, footwear, accessories..."
               class="w-full h-14 pl-12 pr-4 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all outline-none"
               autofocus />
    </div>

    <!-- Search Results -->
    @if($showResults && count($results) > 0)
    <div class="mt-4 max-h-[400px] overflow-y-auto">
        <p class="text-sm text-gray-500 mb-3">Found {{ count($results) }} result(s)</p>
        <div class="space-y-2">
            @foreach($results as $product)
            <div wire:key="search-{{ $product->id }}" 
                 wire:click="viewProduct({{ $product->id }})"
                 class="flex items-center gap-4 p-3 bg-white hover:bg-gray-50 rounded-lg cursor-pointer transition-colors border border-gray-100">
                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                    @if($product->image_groups && $product->image_groups->image_1)
                    <img src="{{ asset('storage/' . $product->image_groups->image_1) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500">{{ ucfirst($product->category) }}@if($product->subcategory) / {{ $product->subcategory }}@endif</p>
                    <p class="text-lg font-bold text-[#4F39F6]">GHS {{ number_format($product->price, 2) }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            @endforeach
        </div>
    </div>
    @elseif($showResults && count($results) === 0)
    <div class="mt-8 text-center py-8">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-gray-500">No products found for "{{ $search }}"</p>
        <p class="text-sm text-gray-400 mt-1">Try searching with different keywords</p>
    </div>
    @endif
</div>
