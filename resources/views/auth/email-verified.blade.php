<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                    <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Email Verified Successfully!
                </h2>
                
                <p class="text-lg text-gray-600 mb-8">
                    Your email has been verified. You now have full access to all features.
                </p>
                
                <!-- Benefits -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8 text-left">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">What's unlocked:</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-[#4F39F6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Track your orders in real-time</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-[#4F39F6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Save delivery addresses for faster checkout</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-[#4F39F6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Get exclusive offers and early access to sales</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-[#4F39F6] mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Leave reviews and help other shoppers</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Action Button -->
                <a href="{{ route('home') }}" 
                   class="inline-block bg-gradient-to-r from-[#4F39F6] to-[#6366F1] text-white font-semibold px-8 py-3 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    Start Shopping
                </a>
            </div>
        </div>
    </div>
</x-layout>
