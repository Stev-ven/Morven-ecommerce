<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Trending extends Component
{
    use LivewireAlert;
    
    public $trending_products = [];
    public $active_tab = 'clothing';
    public $wishlistProductIds = [];

    public function getTrendingProducts()
    {
        // Get trending products based on active tab
        // Trending criteria: combination of recent_sales, total_sales, and recent creation
        $query = Product::with('image_groups')
            ->where('quantity', '>', 0); // Only show in-stock items

        switch ($this->active_tab) {
            case 'clothing':
                $query->where('category', 'clothing');
                break;
            case 'footwear':
                $query->where('category', 'footwear');
                break;
            case 'accessories':
                $query->where('category', 'accessories');
                break;
            case 'activewear':
                $query->where('category', 'activewear');
                break;
            case 'grooming':
                $query->where('category', 'grooming');
                break;
        }

        // Order by multiple factors to determine "trending"
        // 1. Recent sales (most important)
        // 2. Total sales (secondary)
        // 3. Recently created (for new products)
        $this->trending_products = $query
            ->orderByDesc('recent_sales')
            ->orderByDesc('total_sales')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();
        
        // Load wishlist product IDs for current user
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
            return redirect()->back()->with('error', 'Product not found');
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

    public function setActiveTab($tab)
    {
        $this->active_tab = $tab;
        $this->getTrendingProducts();
    }

    public function render()
    {
        $this->getTrendingProducts();
        return view('livewire.products.trending');
    }
}
