<?php

namespace App\Livewire\Wishlist;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class WishlistPage extends Component
{
    use LivewireAlert;

    protected $listeners = ['wishlistUpdated' => '$refresh'];

    public function removeFromWishlist($wishlistId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $wishlistId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->alert('success', 'Removed from wishlist');
            $this->dispatch('wishlistUpdated');
        }
    }

    public function viewProduct($productId)
    {
        $product = Product::with('image_groups')->find($productId);
        if (!$product) {
            return;
        }
        $this->dispatch('open-modal', product: $product->toArray(), component: 'modals.product-modal');
    }

    public function quickView($productId)
    {
        // Redirect to product details page for mobile quick view
        return redirect()->route('product_details', $productId);
    }

    public function addToCart($productId)
    {
        $product = Product::with('image_groups')->find($productId);
        
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

        // Check if product has sizes or colors and needs them - if yes, open modal for selection
        if ($needsColorSize && 
            ((is_array($product->sizes) && count($product->sizes) > 0) || 
             (is_array($product->colors) && count($product->colors) > 0))) {
            $this->viewProduct($productId);
            $this->alert('info', 'Please select size and color');
            return;
        }

        // Only assign default color/size if the product category needs them
        $selectedSize = ($needsColorSize && !empty($product->sizes)) ? $product->sizes[0] : null;
        $selectedColor = ($needsColorSize && !empty($product->colors)) ? $product->colors[0] : null;

        cart()->addToCart($product->id, 1, $selectedSize, $selectedColor);
        
        $this->dispatch('cartUpdated');
        $this->alert('success', 'Added to cart!');
    }

    public function render()
    {
        $wishlists = Wishlist::with('product.image_groups')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('livewire.wishlist.wishlist-page', [
            'wishlists' => $wishlists
        ])->layout('components.layout');
    }
}
