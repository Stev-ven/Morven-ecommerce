<?php

namespace App\Livewire\Payments;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PaystackService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Payment extends Component
{
    use LivewireAlert;
    
    public $cartItems = [];
    public $subtotal = 0;
    public $delivery = 0;
    public $deliveryOption = 'delivery';
    public $paymentMethod = 'card'; // 'card', 'mobile_money', 'cash'
    
    // Guest checkout fields
    public $guestEmail = '';
    public $guestName = '';
    public $guestPhone = '';
    public $createAccount = false;
    public $isGuest = true;

    public function mount()
    {
        $this->cartItems = session('cart', []);
        $this->deliveryOption = session('delivery_option', 'delivery');
        $this->subtotal = collect($this->cartItems)->sum('subtotal');
        
        // Set delivery cost based on option
        $this->delivery = $this->deliveryOption === 'pickup' ? 0 : 0; // Set actual delivery cost if needed
        
        // Check if user is authenticated
        if (Auth::check()) {
            $this->isGuest = false;
            $this->guestEmail = Auth::user()->email;
            $this->guestName = Auth::user()->name;
        }
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    public function initiatePayment()
    {   
        // Validate cart is not empty
        if (empty($this->cartItems)) {
            $this->alert('error', 'Your cart is empty!');
            return redirect()->route('home');
        }

        // If guest, validate guest information
        if ($this->isGuest) {
            $this->validate([
                'guestEmail' => 'required|email',
                'guestName' => 'required|string|max:255',
                'guestPhone' => 'required|string|max:20',
            ], [
                'guestEmail.email' => 'Please enter a valid email address (e.g., user@example.com)',
                'guestEmail.required' => 'Email address is required.',
                'guestName.required' => 'Full name is required.',
                'guestPhone.required' => 'Phone number is required.',
            ]);
        }

        $email = $this->isGuest ? $this->guestEmail : Auth::user()->email;
        $total = $this->subtotal + $this->delivery;

        // Initialize Paystack payment
        $paystack = new PaystackService();
        $reference = $paystack->generateReference();

        // Store order info in session for callback
        session([
            'pending_order' => [
                'reference' => $reference,
                'email' => $email,
                'name' => $this->isGuest ? $this->guestName : Auth::user()->name,
                'phone' => $this->isGuest ? $this->guestPhone : null,
                'cart_items' => $this->cartItems,
                'subtotal' => $this->subtotal,
                'delivery' => $this->delivery,
                'total' => $total,
                'delivery_option' => $this->deliveryOption,
                'payment_method' => $this->paymentMethod,
                'user_id' => Auth::id(),
                'is_guest' => $this->isGuest,
            ]
        ]);

        // Initialize Paystack transaction
        $result = $paystack->initializeTransaction(
            $email,
            $total,
            $reference,
            [
                'user_id' => Auth::id(),
                'cart_items' => count($this->cartItems),
                'delivery_option' => $this->deliveryOption,
            ]
        );

        if ($result['status']) {
            // Redirect to Paystack payment page
            return redirect($result['authorization_url']);
        } else {
            $this->alert('error', 'Payment initialization failed: ' . $result['message']);
        }
    }

    public function showLoginModal()
    {
        $this->dispatch('showLoginModal');
    }

    public function render()
    {
        return view('livewire.payments.payment');
    }
}
