<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Payment extends Component
{
    use LivewireAlert;
    
    public $cartItems = [];
    public $subtotal = 0;
    public $delivery = 0;
    public $deliveryOption = 'delivery';
    public $paymentMethod = 'card'; // 'card', 'mobile_money', 'cash'

    public function mount()
    {
        $this->cartItems = session('cart', []);
        $this->deliveryOption = session('delivery_option', 'delivery');
        $this->subtotal = collect($this->cartItems)->sum('subtotal');
        
        // Set delivery cost based on option
        $this->delivery = $this->deliveryOption === 'pickup' ? 0 : 0; // Set actual delivery cost if needed
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    public function initiatePayment()
    {   
        dd('ggg');
        // Validate cart is not empty
        if (empty($this->cartItems)) {
            $this->alert('error', 'Your cart is empty!');
            return redirect()->route('home');
        }

        

        // Here you would integrate with payment gateway
        // For now, just show success message
        $this->alert('success', 'Order placed successfully!');
        
        // Clear cart
        session()->forget('cart');
        session()->forget('delivery_option');
        
        // Redirect to success page or home
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.home.payment');
    }
}
