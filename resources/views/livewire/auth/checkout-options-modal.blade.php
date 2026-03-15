<div>
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showModal') }">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
             wire:click="hide"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Modal -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-lg transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all"
                 wire:click.stop
                 x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Close Button -->
                <button wire:click="hide" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Header -->
                <div class="p-8 pb-6 text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#4F39F6] to-[#6366F1] rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Ready to Checkout?</h2>
                    <p class="text-gray-600">Choose how you'd like to continue</p>
                </div>

                <!-- Options -->
                <div class="px-8 pb-8 space-y-4">
                    <!-- Continue as Guest -->
                    <button wire:click="continueAsGuest" 
                            class="w-full group relative overflow-hidden bg-gradient-to-r from-[#4F39F6] to-[#6366F1] hover:from-[#3d2bc4] hover:to-[#4F39F6] text-white rounded-xl p-6 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold">Continue as Guest</h3>
                                </div>
                                <p class="text-sm text-white/90">Quick checkout without an account</p>
                            </div>
                            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">OR</span>
                        </div>
                    </div>

                    <!-- Sign In -->
                    <button wire:click="showLogin" 
                            class="w-full group bg-white hover:bg-gray-50 border-2 border-gray-200 hover:border-[#4F39F6] text-gray-800 rounded-xl p-6 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-6 h-6 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold">Sign In</h3>
                                </div>
                                <p class="text-sm text-gray-600">Already have an account? Sign in</p>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-[#4F39F6] transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Create Account -->
                    <button wire:click="showRegister" 
                            class="w-full group bg-white hover:bg-gray-50 border-2 border-gray-200 hover:border-[#4F39F6] text-gray-800 rounded-xl p-6 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-6 h-6 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold">Create Account</h3>
                                </div>
                                <p class="text-sm text-gray-600">New here? Create an account for benefits</p>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-[#4F39F6] transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Benefits -->
                    <div class="mt-6 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl">
                        <p class="text-xs font-semibold text-gray-700 mb-2">Benefits of creating an account:</p>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Track your orders in real-time
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save addresses for faster checkout
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Get exclusive offers and early access
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
