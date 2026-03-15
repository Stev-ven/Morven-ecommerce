<x-layout>
    <div class="home bg-gradient-to-br from-gray-50 to-gray-100 overflow-x-hidden pt-[60px] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-8 h-8 text-[#4F39F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">My Orders</h1>
                </div>
                <p class="text-gray-600">Track and manage your orders</p>
            </div>

            @if($orders->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Orders Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't placed any orders. Start shopping to see your orders here!</p>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Start Shopping</span>
                    </a>
                </div>
            @else
                <!-- Orders List -->
                <div class="space-y-6">
                    @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Order Number</p>
                                        <p class="text-lg font-bold text-gray-800">{{ $order->order_number }}</p>
                                    </div>
                                    <div class="hidden sm:block w-px h-10 bg-gray-300"></div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Order Date</p>
                                        <p class="text-sm font-semibold text-gray-700">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusColor = $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Content -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Order Items -->
                                <div class="lg:col-span-2">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Items ({{ $order->items->count() }})</h3>
                                    <div class="space-y-3">
                                        @foreach($order->items->take(3) as $item)
                                        <div class="flex gap-3">
                                            <div class="w-16 h-16 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                                @if($item->product_image)
                                                <img src="{{ asset('storage/' . $item->product_image) }}" 
                                                     alt="{{ $item->product_name }}"
                                                     class="w-full h-full object-cover">
                                                @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-800 truncate">{{ $item->product_name }}</h4>
                                                <div class="flex flex-wrap gap-2 text-xs text-gray-600 mt-1">
                                                    @if($item->size)
                                                    <span>Size: <span class="font-medium">{{ $item->size }}</span></span>
                                                    @endif
                                                    @if($item->color)
                                                    <span>Color: <span class="font-medium capitalize">{{ $item->color }}</span></span>
                                                    @endif
                                                    <span>Qty: <span class="font-medium">{{ $item->quantity }}</span></span>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-700 mt-1">GHS {{ number_format($item->subtotal, 2) }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        @if($order->items->count() > 3)
                                        <p class="text-sm text-gray-500 italic">+ {{ $order->items->count() - 3 }} more item(s)</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="lg:border-l lg:pl-6">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Order Summary</h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span class="font-medium text-gray-800">GHS {{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Delivery</span>
                                            <span class="font-medium text-gray-800">GHS {{ number_format($order->delivery_fee, 2) }}</span>
                                        </div>
                                        <div class="border-t border-gray-200 pt-3">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold text-gray-800">Total</span>
                                                <span class="text-xl font-bold text-[#4F39F6]">GHS {{ number_format($order->total, 2) }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="pt-3 space-y-2">
                                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>{{ ucfirst($order->payment_status) }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                </svg>
                                                <span class="capitalize">{{ str_replace('_', ' ', $order->delivery_option) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row gap-3 justify-end">
                                <a href="{{ route('order.invoice.download', $order->id) }}" 
                                   class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>Download Invoice</span>
                                </a>
                                
                                <a href="{{ route('order.details', $order->id) }}" 
                                   class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium border border-gray-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>View Details</span>
                                </a>
                                
                                @if($order->order_status === 'delivered')
                                <button class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span>Leave Review</span>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layout>
