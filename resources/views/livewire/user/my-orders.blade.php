<x-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <p class="mt-2 text-gray-600">Track and manage your orders</p>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Orders</label>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search"
                               placeholder="Order number or product name..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-transparent">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                        <select wire:model.live="selectedStatus"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-transparent">
                            <option value="all">All Orders</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <!-- Order Header -->
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex items-center gap-6">
                                        <div>
                                            <p class="text-sm text-gray-600">Order Number</p>
                                            <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Date</p>
                                            <p class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Total</p>
                                            <p class="font-semibold text-[#4F39F6]">GHS {{ number_format($order->total, 2) }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'shipped' => 'bg-purple-100 text-purple-800',
                                                'delivered' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                            $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $colorClass }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-4">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <img src="{{ $item->product_image ?? '/images/placeholder.jpg' }}" 
                                                     alt="{{ $item->product_name }}"
                                                     class="w-20 h-20 object-cover rounded-lg">
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item->product_name }}</h4>
                                                <div class="mt-1 flex items-center gap-4 text-sm text-gray-600">
                                                    @if($item->size)
                                                        <span>Size: {{ $item->size }}</span>
                                                    @endif
                                                    @if($item->color)
                                                        <span>Color: {{ $item->color }}</span>
                                                    @endif
                                                    <span>Qty: {{ $item->quantity }}</span>
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">GHS {{ number_format($item->price, 2) }}</p>
                                                <p class="text-xs text-gray-600">× {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Order Summary -->
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center text-sm">
                                        <div class="space-y-1">
                                            <p class="text-gray-600">
                                                <span class="font-medium">Delivery:</span> {{ ucfirst($order->delivery_option) }}
                                            </p>
                                            <p class="text-gray-600">
                                                <span class="font-medium">Payment:</span> {{ ucfirst($order->payment_method) }}
                                            </p>
                                        </div>
                                        <div class="text-right space-y-1">
                                            <p class="text-gray-600">Subtotal: GHS {{ number_format($order->subtotal, 2) }}</p>
                                            <p class="text-gray-600">Delivery: GHS {{ number_format($order->delivery_fee, 2) }}</p>
                                            <p class="text-lg font-semibold text-gray-900">Total: GHS {{ number_format($order->total, 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 flex gap-3">
                                    <a href="{{ route('order.details', $order->id) }}" 
                                       class="flex-1 text-center px-4 py-2 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors duration-200">
                                        View Details
                                    </a>
                                    @if($order->status === 'delivered')
                                        <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                            Leave Review
                                        </button>
                                    @endif
                                    @if(in_array($order->status, ['pending', 'processing']))
                                        <button class="px-4 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                            Cancel Order
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No orders found</h3>
                    <p class="mt-2 text-gray-600">
                        @if($search || $selectedStatus !== 'all')
                            Try adjusting your filters
                        @else
                            Start shopping to see your orders here
                        @endif
                    </p>
                    <a href="{{ route('home') }}" 
                       class="mt-6 inline-block px-6 py-3 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors duration-200">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layout>
