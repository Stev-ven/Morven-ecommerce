@props(['page_content'])

<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Trending Products</h2>
            <p class="text-lg text-gray-600">Discover what's popular right now</p>
        </div> --}}

        <!-- This will be replaced by the Livewire component -->
        <livewire:products.trending />
    </div>
</div>
