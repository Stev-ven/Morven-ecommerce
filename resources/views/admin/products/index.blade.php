<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#4F39F6]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-800">Products Management</h1>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors font-medium">
                        Add New Product
                    </a>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonColor: '#4F39F6',
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>
            @endif

            @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        icon: 'error',
                        confirmButtonColor: '#4F39F6'
                    });
                });
            </script>
            @endif

            <!-- Search Bar -->
            <div class="mb-6">
                <form method="GET" action="{{ route('admin.products') }}" class="flex gap-3">
                    <div class="flex-1 relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by name, category, subcategory, or brand..."
                               class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors font-medium">
                        Search
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.products') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Clear
                    </a>
                    @endif
                </form>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Image</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Name</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Category</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Subcategory</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Price</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Stock</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                        @if($product->image_groups && $product->image_groups->image_1)
                                        <img src="{{ asset('storage/' . $product->image_groups->image_1) }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $product->name }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ ucfirst($product->category) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-600">{{ $product->subcategory ?? '-' }}</td>
                                <td class="py-3 px-4 text-sm font-semibold text-gray-800">GHS {{ number_format($product->price, 2) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $product->quantity }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-800 delete-btn" data-product-name="{{ $product->name }}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-500">No products found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @forelse($products as $product)
                <div class="bg-white rounded-xl shadow-lg p-4">
                    <div class="flex gap-4">
                        <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                            @if($product->image_groups && $product->image_groups->image_1)
                            <img src="{{ asset('storage/' . $product->image_groups->image_1) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600">{{ ucfirst($product->category) }}@if($product->subcategory) / {{ $product->subcategory }}@endif</p>
                            <p class="text-lg font-bold text-[#4F39F6] mt-1">GHS {{ number_format($product->price, 2) }}</p>
                            <p class="text-sm text-gray-600">Stock: {{ $product->quantity }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm text-center">Edit</a>
                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="flex-1 delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm delete-btn" data-product-name="{{ $product->name }}">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow-lg p-8 text-center text-gray-500">
                    No products found
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productName = this.getAttribute('data-product-name');
                    const form = this.closest('.delete-form');
                    
                    Swal.fire({
                        title: 'Delete Product?',
                        html: `Are you sure you want to delete <strong>${productName}</strong>?<br><span class="text-sm text-gray-600">This action cannot be undone.</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
