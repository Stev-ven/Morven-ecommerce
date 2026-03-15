<div>
    @auth
        @if (!Auth::user()->hasVerifiedEmail() && !$dismissed)
            <div class="fixed top-[70px] left-0 right-0 z-40 bg-gradient-to-r from-yellow-50 to-orange-50 border-b-2 border-yellow-200 shadow-md"
                x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-full">
                <div class="max-w-7xl mx-auto px-4 py-3">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">
                                    <span class="font-semibold">Verify your email</span> to unlock all features
                                </p>
                                <p class="text-xs text-gray-600 mt-0.5">
                                    Check your inbox for the verification link or click resend
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button wire:click="resendVerification()"
                                class="px-4 py-2 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="hidden sm:inline">Resend Email</span>
                                {{-- <span class="sm:hidden">Resend</span> --}}
                            </button>
                            <button wire:click="dismiss" @click="show = false"
                                class="p-2 hover:bg-yellow-100 rounded-lg transition-colors cursor-pointer">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
</div>
