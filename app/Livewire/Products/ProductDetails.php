<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductDetails extends Component
{   
    use LivewireAlert;
    
    public $product_id, $product, $relatedProducts;
    public $selectedSize = null;
    public $selectedColor = null;
    public $quantity = 1;
    public $isInCart = false;

    public function mount($product_id){
        $this->product_id = $product_id;
    }
    
    public function findProduct($product_id){
        $product = Product::with('image_groups')->find($product_id);
        if(empty($product)){
            return redirect()->back()->with('error', 'Product not found');
        }
        $this->product = $product;
        
        // Auto-select first size and color if available
        if (!empty($this->product->sizes)) {
            $this->selectedSize = $this->product->sizes[0];
        }
        if (!empty($this->product->colors)) {
            $this->selectedColor = $this->product->colors[0];
        }
        
        // Check if product is in cart
        $this->checkIfInCart();
        
        // Fetch related products from same category, excluding current product
        $this->relatedProducts = Product::with('image_groups')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    public function checkIfInCart()
    {
        $cart = session()->get('cart', []);
        $cartKey = $this->product->id . '_' . $this->selectedSize . '_' . $this->selectedColor;
        $this->isInCart = isset($cart[$cartKey]);
    }

    public function selectSize($size)
    {
        $this->selectedSize = $size;
        $this->checkIfInCart();
    }

    public function selectColor($color)
    {
        $this->selectedColor = $color;
        $this->checkIfInCart();
    }

    public function incrementQuantity()
    {
        $availableStock = $this->product->quantity ?? 0;
        if ($this->quantity < $availableStock) {
            $this->quantity++;
        } else {
            $this->alert('warning', 'Cannot exceed available stock (' . $availableStock . ' items)');
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        // Validate selections
        if (!empty($this->product->sizes) && !$this->selectedSize) {
            $this->alert('error', 'Please select a size');
            return;
        }

        if (!empty($this->product->colors) && !$this->selectedColor) {
            $this->alert('error', 'Please select a color');
            return;
        }

        // Validate quantity against available stock
        $availableStock = $this->product->quantity ?? 0;
        if ($this->quantity > $availableStock) {
            $this->alert('error', 'Selected quantity (' . $this->quantity . ') exceeds available stock (' . $availableStock . ')');
            $this->quantity = min($this->quantity, $availableStock);
            return;
        }

        if ($availableStock <= 0) {
            $this->alert('error', 'This product is out of stock');
            return;
        }

        // Add to cart with selected options
        cart()->addToCart(
            $this->product->id, 
            $this->quantity,
            $this->selectedSize,
            $this->selectedColor
        );
        
        $this->dispatch('cartUpdated');
        $this->alert('success', 'Item added to cart!');
        
        // Update cart status
        $this->checkIfInCart();
        
        // Reset quantity
        $this->quantity = 1;
    }

    public function removeFromCart()
    {
        $cartKey = $this->product->id . '_' . $this->selectedSize . '_' . $this->selectedColor;
        cart()->removeFromCart($cartKey);
        $this->dispatch('cartUpdated');
        $this->alert('success', 'Item removed from cart!');
        
        // Update cart status
        $this->checkIfInCart();
    }

    public function viewProduct($product_id)
    {
        return redirect()->route('product_details', $product_id);
    }
    
    public function render()
    {   
        $this->findProduct($this->product_id);
        return view('livewire.products.product-details');
    }
}
