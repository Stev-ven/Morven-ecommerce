<div>
    @if ($open && $component)
        @if ($component == 'modals.product-modal')
            <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" 
                 wire:click="hide">
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[95vh] overflow-hidden" 
                     @click.stop>
                    <button wire:click="hide" class="absolute top-4 right-4 z-20 w-10 h-10 flex items-center justify-center bg-white/90 hover:bg-white rounded-full shadow-lg text-gray-600 hover:text-gray-900 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    @livewire($component, ['product' => $product], key('product-modal-'.$product['id'] ?? 'default'))
                </div>
            </div>
        @endif

        @if ($component == 'modals.cart-modal')
            <div class="fixed inset-0 z-[60] flex justify-end bg-black/50 h-[100vh]" wire:click="hide">
                <div
                    class="w-full md:w-[450px] lg:w-[400px] mt-[10%] md:mt-[4%] mr-[1%] h-[90%] mb-[4%] bg-white shadow-2xl p-6 relative" @click.stop>

                    <button type="button" wire:click="hide"
                        class="absolute top-7 md:top-3 right-3 text-gray-600 hover:text-black text-xl z-10">
                        ✖
                    </button>

                    @livewire($component, ['product' => $product])
                </div>
            </div>
        @endif
    @endif
    
    <script>
        document.addEventListener('livewire:init', () => {
            // Ensure we only register the listener once
            if (!window.cartAddedListenerRegistered) {
                window.cartAddedListenerRegistered = true;
                
                Livewire.on('cart-added', () => {
                    console.log('Cart added event received, closing modal in 1 second...');
                    setTimeout(() => {
                        Livewire.dispatch('close-modal');
                    }, 1000);
                });
            }
        });
    </script>
</div>
