@props(['page_content'])

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Shop by Category</h2>
            <p class="text-lg text-gray-600">Discover our curated collections</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="/clothing" class="group">
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-[#4F39F6]/10 rounded-full flex items-center justify-center group-hover:bg-[#4F39F6]/20 transition-colors">
                        <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-[#4F39F6] transition-colors">Clothing</h3>
                </div>
            </a>
            
            <a href="/footwear" class="group">
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-[#4F39F6]/10 rounded-full flex items-center justify-center group-hover:bg-[#4F39F6]/20 transition-colors">
                        <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-[#4F39F6] transition-colors">Footwear</h3>
                </div>
            </a>
            
            <a href="/accessories" class="group">
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-[#4F39F6]/10 rounded-full flex items-center justify-center group-hover:bg-[#4F39F6]/20 transition-colors">
                        <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-[#4F39F6] transition-colors">Accessories</h3>
                </div>
            </a>
            
            <a href="/grooming" class="group">
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-[#4F39F6]/10 rounded-full flex items-center justify-center group-hover:bg-[#4F39F6]/20 transition-colors">
                        <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-[#4F39F6] transition-colors">Grooming</h3>
                </div>
            </a>
        </div>
    </div>
</section>