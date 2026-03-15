<?php

namespace App\Livewire\Home;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Category extends Component
{
    use WithPagination, LivewireAlert;

    public $category;
    public $categorySlug;
    public $wishlistProductIds = [];

    public function mount($category, $categorySlug)
    {
        $this->category = $category;
        $this->categorySlug = $categorySlug;
        $this->loadWishlistIds();
    }

    public function loadWishlistIds()
    {
        if (Auth::check()) {
            $this->wishlistProductIds = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }
    }

    public function viewProduct($product_id)
    {
        $product = Product::with('image_groups')->find($product_id);
        if (!$product) {
            return;
        }
        $this->dispatch('open-modal', product: $product->toArray(), component: 'modals.product-modal');
    }

    public function quickView($product_id)
    {
        // Redirect to product details page for mobile quick view
        return redirect()->route('product_details', $product_id);
    }

    public function addToCart($product_id)
    {
        $product = Product::find($product_id);
        
        if (!$product) {
            $this->alert('error', 'Product not found');
            return;
        }

        if ($product->quantity <= 0) {
            $this->alert('error', 'Product is out of stock');
            return;
        }

        // Define categories/subcategories that don't need color/size
        $noColorSizeCategories = ['grooming', 'accessories'];
        $noColorSizeSubcategories = ['cologne', 'perfumes', 'hair products', 'skincare', 'beard care', 'body care', 'watches', 'belts', 'wallets', 'sunglasses', 'jewelry'];
        
        $needsColorSize = !in_array($product->category, $noColorSizeCategories) && 
                          !in_array($product->subcategory, $noColorSizeSubcategories);

        // Only assign default color/size if the product category needs them
        $selectedSize = ($needsColorSize && !empty($product->sizes)) ? $product->sizes[0] : null;
        $selectedColor = ($needsColorSize && !empty($product->colors)) ? $product->colors[0] : null;

        cart()->addToCart($product->id, 1, $selectedSize, $selectedColor);
        
        $this->dispatch('cartUpdated');
        $this->alert('success', 'Item added to cart!');
    }

    public function toggleWishlist($productId)
    {
        if (!Auth::check()) {
            $this->alert('error', 'Please login to add items to your wishlist');
            $this->dispatch('showLoginModal');
            return;
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->alert('info', 'Removed from wishlist');
            // Remove from local array
            $this->wishlistProductIds = array_diff($this->wishlistProductIds, [$productId]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            $this->alert('success', 'Added to wishlist!');
            // Add to local array
            $this->wishlistProductIds[] = $productId;
        }

        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        // Special handling for footwear to include related subcategories
        if ($this->categorySlug === 'footwear') {
            $products = Product::where(function($query) {
                $query->where('category', 'footwear')
                      ->orWhereIn('subcategory', ['sneakers', 'sandals', 'shoes']);
            })
            ->with('image_groups')
            ->paginate(20);
        } else {
            $products = Product::where('category', $this->categorySlug)
                ->with('image_groups')
                ->paginate(20);
        }

        return view('livewire.home.category', compact('products'));
    }
}
