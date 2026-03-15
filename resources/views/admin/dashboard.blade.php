<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Morven</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Admin Header -->
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#4F39F6] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
                            <p class="text-sm text-gray-600">Morven Management</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-[#4F39F6] transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                        <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Pending Orders</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                            <p class="text-3xl font-bold text-green-600">GHS
                                {{ number_format($stats['total_revenue'], 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Users</p>
                            <p class="text-3xl font-bold text-[#4F39F6]">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#4F39F6]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Orders by Status -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Orders by Status</h3>
                    <div class="space-y-3">
                        @foreach ($ordersByStatus as $status)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 capitalize">{{ $status->order_status }}</span>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-semibold
                                @if ($status->order_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($status->order_status === 'processing') bg-blue-100 text-blue-800
                                @elseif($status->order_status === 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                    {{ $status->count }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Revenue by Payment Method -->
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Revenue by Payment Method</h3>
                    <div class="space-y-4">
                        @foreach ($revenueByMethod as $method)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="text-gray-700 capitalize">{{ str_replace('_', ' ', $method->payment_method) }}</span>
                                    <span class="font-semibold text-gray-800">GHS
                                        {{ number_format($method->total, 2) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#4F39F6] h-2 rounded-full"
                                        style="width: {{ ($method->total / $stats['total_revenue']) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ request()->hasAny(['payment_status', 'order_status', 'payment_method', 'date_from', 'date_to']) ? 'Filtered Orders' : 'Recent Orders' }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Showing {{ $recentOrders->count() }} of {{ $stats['total_orders'] }} total orders
                        </p>
                    </div>
                    <button onclick="document.getElementById('filterPanel').classList.toggle('hidden')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        <span>Filters</span>
                    </button>
                </div>

                <!-- Filter Panel -->
                <div id="filterPanel"
                    class="mb-6 p-4 bg-gray-50 rounded-lg {{ request()->hasAny(['payment_status', 'order_status', 'payment_method', 'date_from', 'date_to']) ? '' : 'hidden' }}">
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <!-- Payment Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                                <select name="payment_status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-transparent">
                                    <option value="">All</option>
                                    <option value="paid" {{ $paymentStatus === 'paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="pending" {{ $paymentStatus === 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                </select>
                            </div>

                            <!-- Order Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                                <select name="order_status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-transparent">
                                    <option value="">All</option>
                                    <option value="pending" {{ $orderStatus === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ $orderStatus === 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="shipped" {{ $orderStatus === 'shipped' ? 'selected' : '' }}>Shipped
                                    </option>
                                    <option value="delivered" {{ $orderStatus === 'delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                    <option value="cancelled" {{ $orderStatus === 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>

                            <!-- Payment Method Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                <select name="payment_method"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-transparent">
                                    <option value="">All</option>
                                    @foreach ($paymentMethods as $method)
                                        <option value="{{ $method }}"
                                            {{ $paymentMethod === $method ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $method)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date From Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                <input type="date" name="date_from" value="{{ $dateFrom }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-transparent">
                            </div>

                            <!-- Date To Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                <input type="date" name="date_to" value="{{ $dateTo }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-transparent">
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="px-6 py-2 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors font-medium">
                                Apply Filters
                            </button>
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                                Clear Filters
                            </a>
                            @if (request()->hasAny(['payment_status', 'order_status', 'payment_method', 'date_from', 'date_to']))
                                <span class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ $recentOrders->count() }}</span> orders found
                                </span>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Order #</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Customer</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Items</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Total</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Payment</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $order->order_number }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">{{ $order->person_name }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-700">{{ $order->items->count() }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold text-gray-800">GHS
                                        {{ number_format($order->total, 2) }}</td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium
                                        @if ($order->payment_status === 'paid') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium
                                        @if ($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">
                                        {{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                </path>
                                            </svg>
                                            <p class="text-gray-500 text-lg font-medium">No orders found</p>
                                            <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
