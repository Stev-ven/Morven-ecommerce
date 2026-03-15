<div class="w-full min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 pb-24 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Shopping Cart</h1>
            </div>
            <p class="text-gray-600">{{ count($cartItems) }} {{ count($cartItems) === 1 ? 'item' : 'items' }} in your cart</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items Section -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    @if(count($cartItems) > 0)
                        <div class="space-y-6">
                            @foreach ($cartItems as $item)
                                <div class="flex flex-col md:flex-row gap-4 pb-6 border-b border-gray-200 last:border-0">
                                    <!-- Product Image -->
                                    <div class="w-full md:w-40 h-40 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                            alt="{{ $item['name'] }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1 flex flex-col">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ ucfirst($item['name']) }}</h3>
                                                <p class="text-xl font-bold text-[#4F39F6]">GHS {{ number_format($item['price'], 2) }}</p>
                                            </div>
                                            <button wire:click="removeFromCart('{{ $item['product_id'] }}')"
                                                class="text-gray-400 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-lg group">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Options Grid -->
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-auto">
                                            <!-- Color Display -->
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-2">Color</label>
                                                <div class="px-3 py-2 border-2 border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-700">
                                                    {{ ucfirst($item['color'] ?? 'N/A') }}
                                                </div>
                                            </div>

                                            <!-- Size Display -->
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-2">Size</label>
                                                <div class="px-3 py-2 border-2 border-gray-200 rounded-lg bg-gray-50 text-sm text-gray-700">
                                                    {{ ucfirst($item['size'] ?? 'N/A') }}
                                                </div>
                                            </div>

                                            <!-- Quantity Selection -->
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-2">Quantity</label>
                                                <input type="number" min="1" max="{{ $item['available_quantity'] ?? 99 }}"
                                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all text-sm"
                                                    wire:model.live="quantities.{{ $item['product_id'] }}">
                                            </div>
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">Item Subtotal:</span>
                                                <span class="text-lg font-semibold text-gray-800">GHS {{ number_format($item['subtotal'], 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">Your cart is empty</h3>
                            <p class="text-gray-500 mb-6">Add some items to get started!</p>
                            <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors">
                                <span>Continue Shopping</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Delivery Options Section -->
                @if(count($cartItems) > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mt-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Delivery Options</h2>
                        <p class="text-gray-600 text-sm mb-6">Choose how you'd like to receive your order</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Delivery Option -->
                            <div 
                                wire:click="setDeliveryOption('delivery')"
                                class="relative border-2 rounded-xl p-6 cursor-pointer transition-all duration-200 {{ $deliveryOption === 'delivery' ? 'border-[#4F39F6] bg-[#4F39F6]/5' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $deliveryOption === 'delivery' ? 'bg-[#4F39F6] text-white' : 'bg-gray-100 text-gray-600' }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-semibold text-gray-800">Home Delivery</h3>
                                            @if($deliveryOption === 'delivery')
                                                <svg class="w-5 h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">Get your order delivered to your doorstep</p>
                                        <p class="text-xs text-gray-500 mt-2">Delivery within 2-5 business days</p>
                                        <p class="text-sm font-semibold text-[#4F39F6] mt-2">Delivery fee: TBD</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pickup Option -->
                            <div 
                                wire:click="setDeliveryOption('pickup')"
                                class="relative border-2 rounded-xl p-6 cursor-pointer transition-all duration-200 {{ $deliveryOption === 'pickup' ? 'border-[#4F39F6] bg-[#4F39F6]/5' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $deliveryOption === 'pickup' ? 'bg-[#4F39F6] text-white' : 'bg-gray-100 text-gray-600' }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-semibold text-gray-800">Store Pickup</h3>
                                            @if($deliveryOption === 'pickup')
                                                <svg class="w-5 h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">Pick up from our store location</p>
                                        <p class="text-xs text-gray-500 mt-2">Ready for pickup in 1-2 business days</p>
                                        <p class="text-sm font-semibold text-green-600 mt-2">FREE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mt-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Payment Method</h2>
                        <p class="text-gray-600 text-sm mb-6">Choose how you'd like to pay for your order</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pay Now Option -->
                            <div 
                                wire:click="setPaymentMethod('pay_now')"
                                class="relative border-2 rounded-xl p-6 cursor-pointer transition-all duration-200 {{ $paymentMethod === 'pay_now' ? 'border-[#4F39F6] bg-[#4F39F6]/5' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $paymentMethod === 'pay_now' ? 'bg-[#4F39F6] text-white' : 'bg-gray-100 text-gray-600' }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-semibold text-gray-800">Pay Now</h3>
                                            @if($paymentMethod === 'pay_now')
                                                <svg class="w-5 h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">Pay securely with Paystack</p>
                                        <p class="text-xs text-gray-500 mt-2">Card, Mobile Money, Bank Transfer</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            <span class="text-xs text-green-600 font-medium">Secure Payment</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pay on Receive Option -->
                            <div 
                                wire:click="setPaymentMethod('pay_on_receive')"
                                class="relative border-2 rounded-xl p-6 cursor-pointer transition-all duration-200 {{ $paymentMethod === 'pay_on_receive' ? 'border-[#4F39F6] bg-[#4F39F6]/5' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $paymentMethod === 'pay_on_receive' ? 'bg-[#4F39F6] text-white' : 'bg-gray-100 text-gray-600' }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-semibold text-gray-800">Pay on {{ $deliveryOption === 'delivery' ? 'Delivery' : 'Pickup' }}</h3>
                                            @if($paymentMethod === 'pay_on_receive')
                                                <svg class="w-5 h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">Pay with cash when you receive your order</p>
                                        <p class="text-xs text-gray-500 mt-2">Cash payment only</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-xs text-blue-600 font-medium">No prepayment required</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order Summary Section -->
            <div class="lg:w-96">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 lg:sticky lg:top-24 lg:max-h-[calc(100vh-8rem)] lg:overflow-y-auto">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">GHS {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery</span>
                            <span class="font-medium">{{ $delivery > 0 ? 'GHS ' . number_format($delivery, 2) : 'TBD' }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-2xl font-bold text-[#4F39F6]">GHS {{ number_format($subtotal + $delivery, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @if(count($cartItems) > 0)
                        <button wire:click="placeOrder()"
                            class="w-full py-4 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 group">
                            <span>{{ $paymentMethod === 'pay_now' ? 'Proceed to Payment' : 'Place Order' }}</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </button>

                        <!-- Trust Badges -->
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span>Secure checkout</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                <span>Free returns within 30 days</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sticky Checkout Bar -->
    @if(count($cartItems) > 0)
        <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t-2 border-gray-200 shadow-2xl p-4 z-50">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs text-gray-600">Total</p>
                    <p class="text-xl font-bold text-[#4F39F6]">GHS {{ number_format($subtotal + $delivery, 2) }}</p>
                </div>
                <button wire:click="placeOrder()"
                    class="flex-1 max-w-xs py-3 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>{{ $paymentMethod === 'pay_now' ? 'Pay Now' : 'Place Order' }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
