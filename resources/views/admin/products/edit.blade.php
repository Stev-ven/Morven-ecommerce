<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.products') }}" class="text-gray-600 hover:text-[#4F39F6]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
                </div>
            </div>
        </header>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <ul class="list-disc list-inside text-red-800">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price (GHS)</label>
                                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category & Brand -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Category & Brand</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="category" name="category" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                                <option value="">Select Category</option>
                                <option value="clothing" {{ old('category', $product->category) == 'clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="footwear" {{ old('category', $product->category) == 'footwear' ? 'selected' : '' }}>Footwear</option>
                                <option value="accessories" {{ old('category', $product->category) == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                <option value="activewear" {{ old('category', $product->category) == 'activewear' ? 'selected' : '' }}>Activewear</option>
                                <option value="grooming" {{ old('category', $product->category) == 'grooming' ? 'selected' : '' }}>Grooming</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                            <input type="text" id="subcategory" name="subcategory" value="{{ old('subcategory', $product->subcategory) }}"
                                   placeholder="e.g., T-Shirts, Sneakers"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                            <p class="mt-1 text-xs text-gray-500" id="subcategory-hint">Select a category to see examples</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                                   placeholder="e.g., Nike, Adidas"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                        </div>
                    </div>
                </div>

                <!-- Colors & Sizes -->
                <div id="colors-sizes-section">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Colors & Sizes</h2>
                    <p class="text-sm text-gray-600 mb-4" id="colors-sizes-note">
                        Add available colors and sizes for this product. For grooming products (perfumes, skincare, etc.) and accessories, these fields are optional.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Colors -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Available Colors <span id="colors-required" class="text-red-500">*</span>
                            </label>
                            <div id="colors-container" class="space-y-2">
                                @php
                                    $colors = old('colors', $product->colors ?? []);
                                @endphp
                                @if(empty($colors))
                                    <div class="flex gap-2 color-field">
                                        <input type="text" name="colors[]" id="colors-input-0"
                                               placeholder="e.g., Black, Blue"
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                                    </div>
                                @else
                                    @foreach($colors as $index => $color)
                                    <div class="flex gap-2 color-field">
                                        <input type="text" name="colors[]" value="{{ $color }}" {{ $index === 0 ? 'id=colors-input-0' : '' }}
                                               placeholder="e.g., Black, Blue"
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                                        @if($index > 0)
                                        <button type="button" onclick="this.parentElement.remove()"
                                                class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" onclick="addColorField()"
                                    class="mt-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                + Add Color
                            </button>
                        </div>

                        <!-- Sizes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Available Sizes <span id="sizes-required" class="text-red-500">*</span>
                            </label>
                            <div id="sizes-container" class="space-y-2">
                                @php
                                    $sizes = old('sizes', $product->sizes ?? []);
                                @endphp
                                @if(empty($sizes))
                                    <div class="flex gap-2 size-field">
                                        <input type="text" name="sizes[]" id="sizes-input-0"
                                               placeholder="e.g., S, M, L, XL"
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                                    </div>
                                @else
                                    @foreach($sizes as $index => $size)
                                    <div class="flex gap-2 size-field">
                                        <input type="text" name="sizes[]" value="{{ $size }}" {{ $index === 0 ? 'id=sizes-input-0' : '' }}
                                               placeholder="e.g., S, M, L, XL"
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                                        @if($index > 0)
                                        <button type="button" onclick="this.parentElement.remove()"
                                                class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" onclick="addSizeField()"
                                    class="mt-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                + Add Size
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Product Images</h2>
                    <p class="text-sm text-gray-600 mb-4">Upload new images to replace existing ones (optional)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @for($i = 1; $i <= 4; $i++)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Image {{ $i }} @if($i == 1)<span class="text-red-500">*</span>@endif
                            </label>
                            
                            @php
                                $fieldName = "image_$i";
                                $currentImage = $product->image_groups?->$fieldName ?? null;
                            @endphp
                            
                            @if($currentImage)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $currentImage) }}" 
                                     alt="Current Image {{ $i }}"
                                     class="w-full h-40 object-cover rounded-lg border border-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Current image (upload new to replace)</p>
                            </div>
                            @endif
                            
                            <input type="file" name="image_{{ $i }}" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                                   onchange="previewImage(this, {{ $i }})">
                            <div id="preview-{{ $i }}" class="mt-2 hidden">
                                <img src="" alt="Preview" class="w-full h-40 object-cover rounded-lg border border-gray-300">
                                <p class="text-xs text-gray-500 mt-1">New image preview</p>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors font-semibold">
                        Update Product
                    </button>
                    <a href="{{ route('admin.products') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const subcategoryExamples = {
            'clothing': 'e.g., T-Shirts, Shirts, Jeans, Trousers, Jackets, Hoodies, Suits, Shorts',
            'footwear': 'e.g., Sneakers, Boots, Loafers, Sandals, Formal Shoes, Slippers',
            'accessories': 'e.g., Watches, Belts, Wallets, Backpacks, Sunglasses, Caps, Jewelry, Ties',
            'activewear': 'e.g., Gym Shorts, Track Pants, Sports Jerseys, Running Shoes, Compression Wear',
            'grooming': 'e.g., Fragrances, Beard Care, Skincare, Hair Products, Body Care'
        };

        // Initialize the form based on current category
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            if (categorySelect.value) {
                handleCategoryChange(categorySelect.value);
            }
        });

        document.getElementById('category').addEventListener('change', function() {
            handleCategoryChange(this.value);
        });

        function handleCategoryChange(categoryValue) {
            const hint = document.getElementById('subcategory-hint');
            const subcategoryInput = document.getElementById('subcategory');
            const colorsRequired = document.getElementById('colors-required');
            const sizesRequired = document.getElementById('sizes-required');
            const colorsNote = document.getElementById('colors-sizes-note');
            const colorsInput = document.getElementById('colors-input-0');
            const sizesInput = document.getElementById('sizes-input-0');
            const colorsSizesSection = document.getElementById('colors-sizes-section');
            
            const isAccessories = categoryValue === 'accessories';
            const isGrooming = categoryValue === 'grooming';
            const shouldHideColorsSizes = isAccessories || isGrooming;
            
            if (categoryValue && subcategoryExamples[categoryValue]) {
                hint.textContent = subcategoryExamples[categoryValue];
                subcategoryInput.placeholder = subcategoryExamples[categoryValue].split(',')[0].replace('e.g., ', '');
            } else {
                hint.textContent = 'Select a category to see examples';
                subcategoryInput.placeholder = 'e.g., T-Shirts, Sneakers, Watches';
            }

            // Hide/show colors and sizes section based on category
            if (shouldHideColorsSizes) {
                colorsSizesSection.style.display = 'none';
                // Remove required attributes when hidden
                if (colorsInput) colorsInput.removeAttribute('required');
                if (sizesInput) sizesInput.removeAttribute('required');
                // Remove required from all existing inputs
                document.querySelectorAll('input[name="colors[]"]').forEach(input => input.removeAttribute('required'));
                document.querySelectorAll('input[name="sizes[]"]').forEach(input => input.removeAttribute('required'));
            } else {
                colorsSizesSection.style.display = 'block';
                if (colorsRequired) colorsRequired.style.display = 'inline';
                if (sizesRequired) sizesRequired.style.display = 'inline';
                colorsNote.textContent = 'Add available colors and sizes for this product. For grooming products (perfumes, skincare, etc.) and accessories, these fields are optional.';
                if (colorsInput) colorsInput.setAttribute('required', 'required');
                if (sizesInput) sizesInput.setAttribute('required', 'required');
                // Add required to all existing inputs
                document.querySelectorAll('input[name="colors[]"]').forEach(input => input.setAttribute('required', 'required'));
                document.querySelectorAll('input[name="sizes[]"]').forEach(input => input.setAttribute('required', 'required'));
            }
        }

        function addColorField() {
            const container = document.getElementById('colors-container');
            const categorySelect = document.getElementById('category');
            const isAccessories = categorySelect.value === 'accessories';
            const isGrooming = categorySelect.value === 'grooming';
            const shouldHideColorsSizes = isAccessories || isGrooming;
            const requiredAttr = shouldHideColorsSizes ? '' : 'required';
            
            const div = document.createElement('div');
            div.className = 'flex gap-2 color-field';
            div.innerHTML = `
                <input type="text" name="colors[]" ${requiredAttr}
                       placeholder="e.g., Black, Blue"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                <button type="button" onclick="this.parentElement.remove()"
                        class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function addSizeField() {
            const container = document.getElementById('sizes-container');
            const categorySelect = document.getElementById('category');
            const isAccessories = categorySelect.value === 'accessories';
            const isGrooming = categorySelect.value === 'grooming';
            const shouldHideColorsSizes = isAccessories || isGrooming;
            const requiredAttr = shouldHideColorsSizes ? '' : 'required';
            
            const div = document.createElement('div');
            div.className = 'flex gap-2 size-field';
            div.innerHTML = `
                <input type="text" name="sizes[]" ${requiredAttr}
                       placeholder="e.g., S, M, L, XL"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                <button type="button" onclick="this.parentElement.remove()"
                        class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function previewImage(input, imageNumber) {
            const preview = document.getElementById(`preview-${imageNumber}`);
            const img = preview.querySelector('img');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
