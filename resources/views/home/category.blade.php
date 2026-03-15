<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category }} - Morven</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    @include('templates.navbar')

    <div class="pt-[90px] pb-12 px-4 md:px-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $category }}</h1>
            <p class="text-gray-600">Explore our collection of {{ strtolower($category) }} for men</p>
        </div>

        @if ($products->count() > 0)
            <!-- Products Grid -->
            <div class="flex items-center justify-center flex-wrap gap-y-6 gap-x-6 w-full px-4">
                @foreach ($products as $product)
                    <div
                        class="item group relative flex flex-col w-[300px] bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="item-card w-full h-[380px] bg-gray-100 overflow-hidden relative">
                            @if ($product->image_groups && $product->image_groups->image_1)
                                <img src="{{ asset('storage/' . $product->image_groups->image_1) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="No image available"
                                    class="w-full h-full object-cover">
                            @endif

                            <!-- Quick View Button -->
                            <a href="{{ route('product_details', $product->id) }}"
                                class="cursor-pointer absolute inset-0 bg-black/0 hover:bg-black/20 flex items-center justify-center opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300">
                                <span
                                    class="bg-white text-gray-900 font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-[#4F39F6] hover:text-white transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Quick View
                                </span>
                            </a>
                        </div>

                        <div class="item-text p-4">
                            <h1 class="item-name font-semibold text-lg text-gray-900 truncate mb-1">{{ $product->name }}
                            </h1>
                            <h1 class="item-category text-sm text-gray-500 mb-2">
                                {{ $product->subcategory ?? ucfirst($product->category) }}</h1>
                            <div class="flex items-center justify-between">
                                <h1 class="price-text font-bold text-xl text-[#4F39F6]">GHS {{ $product->price }}</h1>
                                <div class="flex gap-1">
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                    <span class="text-xs text-gray-600">4.5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-600 mb-6">We're working on adding more {{ strtolower($category) }} products soon!
                </p>
                <a href="/"
                    class="inline-block px-6 py-3 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors">
                    Back to Home
                </a>
            </div>
        @endif
    </div>

    @include('Components.footer')
    @livewire('modal-manager')
</body>

</html>
