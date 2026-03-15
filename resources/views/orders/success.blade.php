<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - Morven</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4 animate-bounce">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                @if ($order->payment_status === 'paid')
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Payment Successful!</h1>
                    <p class="text-lg text-gray-600">Thank you for your order. We've received your payment.</p>
                @else
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Order Placed Successfully!</h1>
                    <p class="text-lg text-gray-600">Thank you for your order. Payment will be collected on
                        {{ $order->delivery_option === 'delivery' ? 'delivery' : 'pickup' }}.</p>
                @endif
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-[#4F39F6] to-[#3d2bc4] px-6 py-6 text-white">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Order Number</p>
                            <p class="text-2xl font-bold">{{ $order->order_number }}</p>
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-sm opacity-90 mb-1">Order Date</p>
                            <p class="text-lg font-semibold">{{ $order->created_at->format('M d, Y') }}</p>
                            <p class="text-sm opacity-75">{{ $order->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Info -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Customer Information</h3>
                            <div class="space-y-2">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span class="text-gray-700">{{ $order->person_name }}</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span class="text-gray-700">{{ $order->person_telephone }}</span>
                                </div>
                                @if ($order->person_email)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-gray-700">{{ $order->person_email }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Delivery Info -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Delivery Information</h3>
                            <div class="space-y-2">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                        </path>
                                    </svg>
                                    <span
                                        class="text-gray-700 capitalize">{{ str_replace('_', ' ', $order->delivery_option) }}</span>
                                </div>
                                @if ($order->delivery_address)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $order->delivery_address }}</span>
                                    </div>
                                @endif
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex gap-4 pb-4 border-b border-gray-100 last:border-0">
                                <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                    @if ($item->product_image)
                                        <img src="{{ asset('storage/' . $item->product_image) }}"
                                            alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">{{ $item->product_name }}</h4>
                                    <div class="flex flex-wrap gap-3 text-sm text-gray-600 mb-2">
                                        @if ($item->size)
                                            <span class="flex items-center gap-1">
                                                <span class="text-gray-400">Size:</span>
                                                <span class="font-medium">{{ $item->size }}</span>
                                            </span>
                                        @endif
                                        @if ($item->color)
                                            <span class="flex items-center gap-1">
                                                <span class="text-gray-400">Color:</span>
                                                <span class="font-medium capitalize">{{ $item->color }}</span>
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <span class="text-gray-400">Qty:</span>
                                            <span class="font-medium">{{ $item->quantity }}</span>
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">GHS {{ number_format($item->price, 2) }}
                                            each</span>
                                        <span class="font-semibold text-gray-800">GHS
                                            {{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 px-6 py-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">GHS {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery Fee</span>
                            <span class="font-medium">GHS {{ number_format($order->delivery_fee, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-300 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total Paid</span>
                                <span class="text-2xl font-bold text-[#4F39F6]">GHS
                                    {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-green-600 pt-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @if ($order->payment_status === 'paid')
                                <span class="font-medium">Payment confirmed via Paystack</span>
                            @else
                                <span class="font-medium">Payment on
                                    {{ $order->delivery_option === 'delivery' ? 'delivery' : 'pickup' }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-gray-700 rounded-xl shadow-lg hover:shadow-xl transition-all font-semibold border-2 border-gray-200 hover:border-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Continue Shopping</span>
                </a>

                @auth
                    <a href="{{ route('order.invoice.download', $order->id) }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-green-600 text-white rounded-xl shadow-lg hover:shadow-xl hover:bg-green-700 transition-all font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span>Download Invoice</span>
                    </a>

                    <a href="{{ route('my.orders') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#4F39F6] text-white rounded-xl shadow-lg hover:shadow-xl hover:bg-[#3d2bc4] transition-all font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span>View My Orders</span>
                    </a>
                @endauth
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <div
                    class="inline-flex items-center gap-2 text-sm text-gray-600 bg-white px-6 py-3 rounded-full shadow">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>A confirmation email has been sent to <span
                            class="font-medium">{{ $order->person_email ?? 'your email' }}</span></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
