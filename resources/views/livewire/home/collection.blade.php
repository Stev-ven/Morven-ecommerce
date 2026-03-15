<div>
    <div class="groupings pt-[30px] mx-[30px]">
        <h1 class="group-title mt-[10px] text-2xl font-semibold text-gray-600">{{$collection->title}}</h1>
        <div class="group-items flex width-[100%] flex-wrap mt-2">
            <div
                class="item border border-gray-200 w-fit h-fit flex items-center justify-center p-1 rounded-4xl m-2 ml-0">
                <div class="img-icon w-[30px] h-[30px] border border-gray-200 rounded-full bg-gray-200 mr-2">

                </div>
                <div class="item-name mr-2">
                    <h1 class="text-sm font-light hover:text-[#4F39F6]">Jeans</h1>
                </div>
            </div>
            <div
                class="item border border-gray-200 w-fit h-fit flex items-center justify-center p-1 rounded-4xl m-2 ml-0">
                <div class="img-icon w-[30px] h-[30px] border border-gray-200 rounded-full bg-gray-200 mr-2">

                </div>
                <div class="item-name mr-2">
                    <h1 class="text-sm font-light hover:text-[#4F39F6]">Jackets</h1>
                </div>
            </div>
            <div
                class="item border border-gray-200 w-fit h-fit flex items-center justify-center p-1 rounded-4xl m-2 ml-0">
                <div class="img-icon w-[30px] h-[30px] border border-gray-200 rounded-full bg-gray-200 mr-2">

                </div>
                <div class="item-name mr-2">
                    <h1 class="text-sm font-light hover:text-[#4F39F6]">Trousers</h1>
                </div>
            </div>
            <div
                class="item border border-gray-200 w-fit h-fit flex items-center justify-center p-1 rounded-4xl m-2 ml-0">
                <div class="img-icon w-[30px] h-[30px] border border-gray-200 rounded-full bg-gray-200 mr-2">

                </div>
                <div class="item-name mr-2">
                    <h1 class="text-sm font-light hover:text-[#4F39F6]">Shirts</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="items-container px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
           <div class="product group relative flex flex-col w-[300px] bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="img-container w-full h-[380px] bg-gray-100 overflow-hidden relative">
                    <img src="{{ asset('storage/' . $product['image_groups']['image_1']) }}"
                        alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                    <!-- Quick View Button -->
                    <button wire:click="viewProduct({{ $product['id'] }})"
                        class="cursor-pointer absolute inset-0 bg-black/0 hover:bg-black/20 flex items-center justify-center opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300">
                        <span class="bg-white text-gray-900 font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-[#4F39F6] hover:text-white transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Quick View
                        </span>
                    </button>
                </div>

                <div class="item-text p-4">
                    <h1 class="item-name font-semibold text-lg text-gray-900 truncate mb-1">{{ $product['name'] }}</h1>
                    <h1 class="item-category text-sm text-gray-500 mb-2">{{ $product['category'] }} {{ $product['subcategory'] }}</h1>
                    <div class="flex items-center justify-between">
                        <h1 class="price-text font-bold text-xl text-[#4F39F6]">GHS {{ $product['price'] }}</h1>
                        <div class="flex gap-1">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <span class="text-xs text-gray-600">4.5</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

