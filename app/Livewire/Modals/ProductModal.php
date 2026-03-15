<?php

namespace App\Livewire\Modals;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductModal extends Component
{
    use LivewireAlert;
    
    public $product = [];
    public $selectedSize = null;
    public $selectedColor = null;
    public $quantity = 1;
    public $isInCart = false;

    public function mount($product)
    {
        $this->product = $product;
        
        // Set initial quantity, ensuring it doesn't exceed available stock
        $availableStock = $this->product['quantity'] ?? 0;
        $this->quantity = min(1, $availableStock);
        
        // Auto-select first size and color if available
        if (!empty($this->product['sizes'])) {
            $this->selectedSize = $this->product['sizes'][0];
        }
        if (!empty($this->product['colors'])) {
            $this->selectedColor = $this->product['colors'][0];
        }
        
        // Check if product is in cart
        $this->checkIfInCart();
    }

    public function checkIfInCart()
    {
        $cart = session()->get('cart', []);
        $cartKey = $this->product['id'] . '_' . $this->selectedSize . '_' . $this->selectedColor;
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
        $availableStock = $this->product['quantity'] ?? 0;
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

    public function render()
    {
        return view('livewire.modals.product-modal');
    }

    public function addToCart()
    {
        // Validate selections
        if (!empty($this->product['sizes']) && !$this->selectedSize) {
            $this->alert('error', 'Please select a size');
            return;
        }

        if (!empty($this->product['colors']) && !$this->selectedColor) {
            $this->alert('error', 'Please select a color');
            return;
        }

        // Validate quantity against available stock
        $availableStock = $this->product['quantity'] ?? 0;
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
            $this->product['id'], 
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
        
        // Dispatch browser event to close modal after delay
        $this->dispatch('cart-added');
    }

    public function removeFromCart()
    {
        $cartKey = $this->product['id'] . '_' . $this->selectedSize . '_' . $this->selectedColor;
        cart()->removeFromCart($cartKey);
        $this->dispatch('cartUpdated');
        $this->alert('success', 'Item removed from cart!');
        
        // Update cart status
        $this->checkIfInCart();
    }
}
