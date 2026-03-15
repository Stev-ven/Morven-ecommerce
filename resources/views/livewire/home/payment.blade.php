<div class="w-full min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 pb-24 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Payment</h1>
            </div>
            <p class="text-gray-600">Complete your payment to finalize your order</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline">Cart</span>
                </div>
                <div class="w-12 h-0.5 bg-green-500"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline">{{ $deliveryOption === 'pickup' ? 'Pickup' : 'Delivery' }}</span>
                </div>
                <div class="w-12 h-0.5 bg-[#4F39F6]"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-[#4F39F6] text-white flex items-center justify-center font-semibold">3</div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline">Payment</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Payment Methods Section -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Select Payment Method</h2>
                    
                    <div class="space-y-4">
                        <!-- Credit/Debit Card -->
                        <div 
                            wire:click="setPaymentMethod('card')"
                            class="relative border-2 rounded-xl p-6 cursor-pointer transition-all duration-200 {{ $paymentMethod === 'card' ? 'border-[#4F39F6] bg-[#4F39F6]/5' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $paymentMethod === 'card' ? 'bg-[#4F39F6] text-white' : 'bg-gray-100 text-gray-600' }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-semibold text-gray-800">Credit / Debit Card</h3>
                                        @if($paymentMethod === 'card')
                                            <svg class="w-5 h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Pay securely with your card</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Money -->
                        <div 
                            wire:click="setPaymentMethod('mobile_money')"
                            class="relative border-2 rounded-xl p-6 cursor-pointer transition-all duration-200 {{ $paymentMethod === 'mobile_money' ? 'border-[#4F39F6] bg-[#4F39F6]/5' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $paymentMethod === 'mobile_money' ? 'bg-[#4F39F6] text-white' : 'bg-gray-100 text-gray-600' }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-semibold text-gray-800">Mobile Money</h3>
                                        @if($paymentMethod === 'mobile_money')
                                            <svg class="w-5 h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">MTN, Vodafone, AirtelTigo</p>
                                </div>
                            </div>
                        </div>

                        <!-- Cash on Delivery/Pickup -->
                        <div 
                            wire:click="setPaymentMethod('cash')"
                            class="relative border-2 rounded-xl p-6 cursor-pointer transition-all duration-200 {{ $paymentMethod === 'cash' ? 'border-[#4F39F6] bg-[#4F39F6]/5' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $paymentMethod === 'cash' ? 'bg-[#4F39F6] text-white' : 'bg-gray-100 text-gray-600' }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-semibold text-gray-800">Cash {{ $deliveryOption === 'pickup' ? 'on Pickup' : 'on Delivery' }}</h3>
                                        @if($paymentMethod === 'cash')
                                            <svg class="w-5 h-5 text-[#4F39F6]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Pay with cash when you receive your order</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form (shown for card/mobile money) -->
                    @if($paymentMethod !== 'cash')
                        <div class="mt-8 p-6 bg-gray-50 rounded-xl">
                            <h3 class="font-semibold text-gray-800 mb-4">
                                {{ $paymentMethod === 'card' ? 'Card Details' : 'Mobile Money Details' }}
                            </h3>
                            <div class="space-y-4">
                                @if($paymentMethod === 'card')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                        <input type="text" placeholder="1234 5678 9012 3456" 
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                            <input type="text" placeholder="MM/YY" 
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                            <input type="text" placeholder="123" 
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all">
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                        <input type="tel" placeholder="024 123 4567" 
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Network</label>
                                        <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all">
                                            <option>MTN Mobile Money</option>
                                            <option>Vodafone Cash</option>
                                            <option>AirtelTigo Money</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="lg:w-96">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 lg:sticky lg:top-24">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h2>
                    
                    <!-- Delivery Option Badge -->
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">
                            {{ $deliveryOption === 'pickup' ? 'Store Pickup' : 'Home Delivery' }}
                        </span>
                    </div>

                    <!-- Cart Items Preview -->
                    <div class="mb-6 max-h-48 overflow-y-auto custom-scrollbar">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100 last:border-0">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item['qty'] }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-800">GHS {{ number_format($item['subtotal'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 mb-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">GHS {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery</span>
                            <span class="font-medium">{{ $delivery > 0 ? 'GHS ' . number_format($delivery, 2) : 'FREE' }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-2xl font-bold text-[#4F39F6]">GHS {{ number_format($subtotal + $delivery, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <button wire:click="initiatePayment()"
                        class="w-full py-4 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Complete Payment</span>
                    </button>

                    <!-- Security Badge -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>Your payment information is secure and encrypted</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sticky Payment Bar -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t-2 border-gray-200 shadow-2xl p-4 z-50">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs text-gray-600">Total</p>
                <p class="text-xl font-bold text-[#4F39F6]">GHS {{ number_format($subtotal + $delivery, 2) }}</p>
            </div>
            <button wire:click="initiatePayment()"
                class="flex-1 max-w-xs py-3 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                <span>Pay Now</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
