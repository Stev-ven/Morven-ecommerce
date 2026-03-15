<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CartDetails extends Component
{
    use LivewireAlert;
    public $cartItems = [];
    public $subtotal;
    public $quantities = [];
    public $delivery = 0;
    public $deliveryOption = 'delivery'; // 'delivery' or 'pickup'
    public $paymentMethod = 'pay_now'; // 'pay_now' or 'pay_on_receive'
    public $checkout_info = [];

    protected $listeners = [
        'cartUpdated' => 'refreshCart'
    ];

    public function mount()
    {
        $this->refreshCart();

        // Ensure default delivery option exists in session
        if (!Session::has('checkout_info.delivery_option')) {
            Session::put('checkout_info.delivery_option', 'delivery');
        }
        
        // Ensure default payment method exists in session
        if (!Session::has('checkout_info.payment_method')) {
            Session::put('checkout_info.payment_method', 'pay_now');
        }
        
        // Sync Livewire state
        $this->checkout_info = Session::get('checkout_info', []);
        $this->deliveryOption = $this->checkout_info['delivery_option'];
        $this->paymentMethod = $this->checkout_info['payment_method'] ?? 'pay_now';
    }

    public function refreshCart()
    {
        $this->cartItems = session('cart', []);


        foreach ($this->cartItems as $item) {
            $this->quantities[$item['product_id']] = $item['qty'];
        }
        $this->subtotal = collect($this->cartItems)->map(fn($item) => $item['price'] * $item['qty'])->sum();
    }

    public function removeFromCart($productId)
    {
        cart()->removeFromCart($productId);

        $this->refreshCart();
        $this->dispatch('cartUpdated');
        $this->alert('success', 'Item removed from cart!');
    }

    public function updatedQuantities($qty, $productId)
    {
        $qty = max(1, (int) $qty);

        app(\App\Services\CartService::class)
            ->updateQuantity($productId, $qty);

        $this->refreshCart();
    }

    public function setDeliveryOption($option)
    {
        $this->deliveryOption = $option;
        $this->delivery = $option === 'pickup' ? 0 : 0;

        Session::put('checkout_info.delivery_option', $option);

        $this->checkout_info = Session::get('checkout_info', []);
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
        Session::put('checkout_info.payment_method', $method);
        $this->checkout_info = Session::get('checkout_info', []);
    }


    public function placeOrder()
    {
        // Store delivery option and payment method in session
        session(['delivery_option' => $this->deliveryOption]);
        session(['payment_method' => $this->paymentMethod]);

        // Check if user is authenticated
        if (!\Illuminate\Support\Facades\Auth::check()) {
            // Show checkout options modal for guests
            $this->dispatch('showCheckoutOptions', route: 'placeOrder');
            return;
        }

        // If authenticated, proceed to checkout
        return redirect()->route('placeOrder');
    }

    public function render()
    {
        return view('livewire.home.cart-details');
    }
}
