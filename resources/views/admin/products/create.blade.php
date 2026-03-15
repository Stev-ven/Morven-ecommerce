<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Morven Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-[#4F39F6]">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Add New Product</h1>
                </div>
                <a href="{{ route('admin.products') }}" class="text-sm text-gray-600 hover:text-[#4F39F6]">
                    View All Products
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name
                            *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                            placeholder="e.g., Classic Leather Jacket">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description
                            *</label>
                        <textarea id="description" name="description" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                            placeholder="Detailed product description...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (GHS)
                                *</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}"
                                step="0.01" min="0" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                                placeholder="0.00">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity
                                *</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                                min="0" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                                placeholder="0">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category & Brand -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Category & Brand</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select id="category" name="category" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]">
                            <option value="">Select Category</option>
                            <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Clothing
                            </option>
                            <option value="footwear" {{ old('category') == 'footwear' ? 'selected' : '' }}>Footwear
                            </option>
                            <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>
                                Accessories</option>
                            <option value="activewear" {{ old('category') == 'activewear' ? 'selected' : '' }}>
                                Activewear</option>
                            <option value="grooming" {{ old('category') == 'grooming' ? 'selected' : '' }}>Grooming
                            </option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subcategory"
                            class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                        <input type="text" id="subcategory" name="subcategory" value="{{ old('subcategory') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                            placeholder="e.g., T-Shirts, Sneakers, Watches">
                        <p class="mt-1 text-xs text-gray-500" id="subcategory-hint">Select a category to see examples
                        </p>
                        @error('subcategory')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                            placeholder="e.g., Nike, Adidas">
                        @error('brand')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Colors & Sizes -->
            <div class="bg-white rounded-lg shadow-sm p-6" id="colors-sizes-section">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Colors & Sizes</h2>
                <p class="text-sm text-gray-600 mb-4" id="colors-sizes-note">
                    Add available colors and sizes for this product. For grooming products (perfumes, skincare, etc.),
                    these fields are optional.
                </p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Available Colors <span id="colors-required" class="text-red-500">*</span>
                        </label>
                        <div id="colors-container" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="colors[]" value="{{ old('colors.0') }}"
                                    id="colors-input-0"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                                    placeholder="e.g., Black">
                            </div>
                        </div>
                        <button type="button" onclick="addColorField()"
                            class="mt-2 text-sm text-[#4F39F6] hover:text-[#3d2bc4]">
                            <i class="fas fa-plus mr-1"></i> Add Another Color
                        </button>
                        @error('colors')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Available Sizes <span id="sizes-required" class="text-red-500">*</span>
                        </label>
                        <div id="sizes-container" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="sizes[]" value="{{ old('sizes.0') }}"
                                    id="sizes-input-0"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                                    placeholder="e.g., M, L, XL or 42, 43, 44">
                            </div>
                        </div>
                        <button type="button" onclick="addSizeField()"
                            class="mt-2 text-sm text-[#4F39F6] hover:text-[#3d2bc4]">
                            <i class="fas fa-plus mr-1"></i> Add Another Size
                        </button>
                        @error('sizes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Product Images -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Images</h2>
                <p class="text-sm text-gray-600 mb-4">Upload up to 4 images. First image will be the main product
                    image.</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @for ($i = 1; $i <= 4; $i++)
                        <div>
                            <label for="image_{{ $i }}"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Image {{ $i }} {{ $i === 1 ? '*' : '' }}
                            </label>
                            <div class="relative">
                                <input type="file" id="image_{{ $i }}"
                                    name="image_{{ $i }}" accept="image/*"
                                    {{ $i === 1 ? 'required' : '' }} class="hidden"
                                    onchange="previewImage(this, {{ $i }})">
                                <label for="image_{{ $i }}" class="block cursor-pointer">
                                    <div id="preview_{{ $i }}"
                                        class="w-full h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center hover:border-[#4F39F6] transition-colors">
                                        <div class="text-center">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400"></i>
                                            <p class="text-xs text-gray-500 mt-1">Click to upload</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error("image_$i")
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.products') }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-[#4F39F6] text-white rounded-lg hover:bg-[#3d2bc4] transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create Product
                </button>
            </div>
        </form>
    </main>

    <script>
        const subcategoryExamples = {
            'clothing': 'e.g., T-Shirts, Shirts, Jeans, Trousers, Jackets, Hoodies, Suits, Shorts',
            'footwear': 'e.g., Sneakers, Boots, Loafers, Sandals, Formal Shoes, Slippers',
            'accessories': 'e.g., Watches, Belts, Wallets, Backpacks, Sunglasses, Caps, Jewelry, Ties',
            'activewear': 'e.g., Gym Shorts, Track Pants, Sports Jerseys, Running Shoes, Compression Wear',
            'grooming': 'e.g., Fragrances, Beard Care, Skincare, Hair Products, Body Care'
        };

        document.getElementById('category').addEventListener('change', function() {
            const hint = document.getElementById('subcategory-hint');
            const subcategoryInput = document.getElementById('subcategory');
            const colorsRequired = document.getElementById('colors-required');
            const sizesRequired = document.getElementById('sizes-required');
            const colorsNote = document.getElementById('colors-sizes-note');
            const colorsInput = document.getElementById('colors-input-0');
            const sizesInput = document.getElementById('sizes-input-0');
            const colorsSizesSection = document.getElementById('colors-sizes-section');

            const isAccessories = this.value === 'accessories';
            const isGrooming = this.value === 'grooming';
            const shouldHideColorsSizes = isAccessories || isGrooming;

            if (this.value && subcategoryExamples[this.value]) {
                hint.textContent = subcategoryExamples[this.value];
                subcategoryInput.placeholder = subcategoryExamples[this.value].split(',')[0].replace('e.g., ', '');
            } else {
                hint.textContent = 'Select a category to see examples';
                subcategoryInput.placeholder = 'e.g., T-Shirts, Sneakers, Watches';
            }

            // Hide/show colors and sizes section based on category
            if (shouldHideColorsSizes) {
                colorsSizesSection.style.display = 'none';
                // Remove required attributes when hidden
                colorsInput.removeAttribute('required');
                sizesInput.removeAttribute('required');
                // Clear values when hidden
                colorsInput.value = '';
                sizesInput.value = '';
            } else {
                colorsSizesSection.style.display = 'block';
                colorsRequired.style.display = 'inline';
                sizesRequired.style.display = 'inline';
                colorsNote.textContent =
                    'Add available colors and sizes for this product. For grooming products (perfumes, skincare, etc.), these fields are optional.';
                colorsInput.setAttribute('required', 'required');
                sizesInput.setAttribute('required', 'required');
                colorsInput.placeholder = 'e.g., Black';
                sizesInput.placeholder = 'e.g., M, L, XL or 42, 43, 44';
            }
        });

        function addColorField() {
            const container = document.getElementById('colors-container');
            const categorySelect = document.getElementById('category');
            const isGrooming = categorySelect.value === 'grooming';
            const requiredAttr = isGrooming ? '' : 'required';

            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="colors[]" ${requiredAttr}
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                    placeholder="${isGrooming ? 'e.g., Natural (optional)' : 'e.g., Blue'}">
                <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addSizeField() {
            const container = document.getElementById('sizes-container');
            const categorySelect = document.getElementById('category');
            const isGrooming = categorySelect.value === 'grooming';
            const requiredAttr = isGrooming ? '' : 'required';

            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="sizes[]" ${requiredAttr}
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F39F6] focus:border-[#4F39F6]"
                    placeholder="${isGrooming ? 'e.g., 100ml (optional)' : 'e.g., XL'}">
                <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function previewImage(input, imageNumber) {
            const preview = document.getElementById(`preview_${imageNumber}`);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">
                    `;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
