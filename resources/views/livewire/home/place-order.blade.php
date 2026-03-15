<div class="w-full min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 pb-24 lg:pb-8">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Checkout</h1>
            </div>
            <p class="text-gray-600">Complete your order details</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center gap-4">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline">Cart</span>
                </div>
                <div class="w-12 h-0.5 bg-green-500"></div>
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 rounded-full bg-[#4F39F6] text-white flex items-center justify-center font-semibold">
                        2</div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline">Checkout</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-300"></div>
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold">
                        3</div>
                    <span class="text-sm font-medium text-gray-500 hidden sm:inline">Complete</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Checkout Form Section -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">
                        {{ $deliveryOption === 'delivery' ? 'Delivery Information' : 'Pickup Information' }}
                    </h2>

                    @if ($deliveryOption === 'pickup')
                        <!-- Store Pickup Form -->
                        <div class="space-y-6">
                            <!-- Store Location Info -->
                            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mb-6">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">Morven Store - Accra Mall</h3>
                                        <p class="text-gray-700 mb-2">Tetteh Quarshie Interchange, Accra</p>
                                        <p class="text-sm text-gray-600 mb-3">Open: Mon-Sat 9:00 AM - 8:00 PM, Sun 10:00
                                            AM - 6:00 PM</p>
                                        <div class="flex items-center gap-2 text-sm text-blue-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                            <span>+233 24 123 4567</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div>
                                <label for="person_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="person_name" wire:model="person_name"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all"
                                    placeholder="Enter your full name" required>
                                @error('person_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="person_telephone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="person_telephone" wire:model="person_telephone"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all"
                                    placeholder="0XXXXXXXXX" required>
                                @error('person_telephone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">We'll call you when your order is ready for pickup
                                </p>
                            </div>

                            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-sm text-yellow-800">
                                        <p class="font-semibold mb-1">Pickup Instructions:</p>
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Bring a valid ID for verification</li>
                                            <li>Order will be ready within 1-2 business days</li>
                                            <li>You'll receive a confirmation call</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Home Delivery Form -->
                        <!-- Personal Details -->
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Full Name
                                    </span>
                                </label>
                                <input type="text" wire:model="person_name"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all"
                                    placeholder="Enter your full name">
                                @error('person_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Email Address
                                        @guest
                                            <span class="text-xs text-red-500 font-normal">(Required for payment)</span>
                                        @else
                                            <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                                        @endguest
                                    </span>
                                </label>
                                <input type="email" wire:model="person_email"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all"
                                    placeholder="your.email@example.com" @guest required @endguest>
                                @error('person_email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                                @guest
                                    <p class="text-xs text-gray-500 mt-1">We'll send your payment receipt to this email</p>
                                @endguest
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        Mobile Number
                                    </span>
                                </label>
                                <input type="tel" wire:model="person_telephone"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all"
                                    placeholder="Enter your mobile number">
                                @error('person_telephone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Delivery Address
                                    </span>
                                </label>
                                <input type="text" wire:model="delivery_address"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all"
                                    placeholder="Enter your delivery address">
                                @error('delivery_address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Map Section -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Select Delivery Location</h3>
                            <p class="text-sm text-gray-600 mb-4">Zoom in and click on the map to set your precise
                                delivery
                                location, or use the search box below.</p>

                            <!-- Search Box -->
                            <div class="relative mb-4">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input id="pac-input"
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all"
                                    type="text" placeholder="Search for a location...">
                            </div>

                            <!-- Map Container -->
                            <div
                                class="relative w-full h-[400px] border-2 border-gray-200 rounded-2xl overflow-hidden shadow-inner">
                                <div wire:ignore id="map" class="w-full h-full"></div>
                            </div>

                            <!-- Coordinates Display -->
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-2">Latitude</label>
                                    <input type="text" id="latitude" wire:model.live="latitude"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all text-sm bg-gray-50"
                                        readonly>
                                    @error('latitude')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-2">Longitude</label>
                                    <input type="text" id="longitude" wire:model.live="longitude"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#4F39F6] focus:ring-2 focus:ring-[#4F39F6]/20 transition-all text-sm bg-gray-50"
                                        readonly>
                                    @error('longitude')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <script>
                            let map, marker;

                            function initMap() {
                                const defaultLocation = {
                                    lat: 5.6037,
                                    lng: -0.1870
                                };

                                map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 13,
                                    center: defaultLocation,
                                    mapTypeId: 'roadmap',
                                    styles: [{
                                        featureType: "poi",
                                        elementType: "labels",
                                        stylers: [{
                                            visibility: "off"
                                        }]
                                    }]
                                });

                                marker = new google.maps.Marker({
                                    map,
                                    position: defaultLocation,
                                    draggable: true,
                                    animation: google.maps.Animation.DROP
                                });

                                const input = document.getElementById('pac-input');
                                const searchBox = new google.maps.places.SearchBox(input);

                                map.addListener('bounds_changed', () => {
                                    searchBox.setBounds(map.getBounds());
                                });

                                searchBox.addListener('places_changed', () => {
                                    const places = searchBox.getPlaces();
                                    if (places.length === 0 || !places[0].geometry) return;

                                    const location = places[0].geometry.location;
                                    map.setCenter(location);
                                    map.setZoom(15);
                                    marker.setPosition(location);
                                    marker.setAnimation(google.maps.Animation.BOUNCE);
                                    setTimeout(() => marker.setAnimation(null), 2000);
                                    updateLatLng(location.lat(), location.lng());
                                });

                                map.addListener('click', (e) => {
                                    marker.setPosition(e.latLng);
                                    marker.setAnimation(google.maps.Animation.BOUNCE);
                                    setTimeout(() => marker.setAnimation(null), 1000);
                                    updateLatLng(e.latLng.lat(), e.latLng.lng());
                                });

                                marker.addListener('dragend', (e) => {
                                    updateLatLng(e.latLng.lat(), e.latLng.lng());
                                });
                            }

                            function updateLatLng(lat, lng) {
                                // Update the input fields
                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;

                                // Dispatch to Livewire component
                                @this.call('updateCoordinates', lat, lng);
                            }

                            document.addEventListener('livewire:load', () => {
                                // initMap will be triggered via callback in script src
                            });
                        </script>

                        <!-- Load Google Maps JS with Places library -->
                        <script async defer
                            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap">
                        </script>
                    @endif
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="lg:w-96">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 lg:sticky lg:top-24">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h2>

                    <!-- Cart Items Preview -->
                    <div class="mb-6 max-h-48 overflow-y-auto custom-scrollbar">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100 last:border-0">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item['qty'] }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-800">GHS
                                    {{ number_format($item['subtotal'], 2) }}</p>
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
                            <span
                                class="font-medium">{{ $delivery > 0 ? 'GHS ' . number_format($delivery, 2) : 'TBD' }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-2xl font-bold text-[#4F39F6]">GHS
                                    {{ number_format($subtotal + $delivery, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <button wire:click="placeOrder()"
                        class="w-full py-4 bg-[#4F39F6] hover:bg-[#3d2bc4] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $paymentMethod === 'pay_now' ? 'Proceed to Payment' : 'Place Order' }}</span>
                    </button>

                    <!-- Trust Badges -->
                    <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            <span>Secure payment processing</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Fast delivery within 2-5 days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sticky Checkout Bar -->
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
