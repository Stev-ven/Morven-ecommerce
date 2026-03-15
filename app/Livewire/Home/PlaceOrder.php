<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PlaceOrder extends Component
{

    use LivewireAlert;
    public $cartItems, $subtotal, $quantities, $delivery = 0;
    public $latitude, $longitude;
    public $person_name;
    public $person_email;
    public $person_telephone;
    public $delivery_address;
    public $paymentMethod = 'pay_now';
    public $deliveryOption = 'delivery';

    #[On('updateCoordinates')]
    public function updateCoordinates($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }


    public function mount()
    {
        $this->refreshCart();
        $this->paymentMethod = session('payment_method', 'pay_now');
        $checkout_info = Session::get('checkout_info', []);
        $this->deliveryOption = $checkout_info['delivery_option'] ?? 'delivery';
    }

    public function refreshCart()
    {
        $this->cartItems = session('cart', []);


        foreach ($this->cartItems as $item) {
            $this->quantities[$item['product_id']] = $item['qty'];
        }
        $this->subtotal = collect($this->cartItems)->map(fn($item) => $item['price'] * $item['qty'])->sum();
    }

    public function updateCheckoutInfo()
    {
        $checkout_info = Session::get('checkout_info', []);

        if (($checkout_info['delivery_option'] ?? null) === 'delivery') {

            $checkout_info['person_name']      = $this->person_name;
            $checkout_info['person_email']     = $this->person_email;
            $checkout_info['person_telephone'] = $this->person_telephone;
            $checkout_info['delivery_address'] = $this->delivery_address;
            $checkout_info['latitude']         = $this->latitude;
            $checkout_info['longitude']        = $this->longitude;
            $checkout_info['cart_items'] = $this->cartItems;

            Session::put('checkout_info', $checkout_info);
        }
    }

    public function placeOrder()
    {   
        
        $rules = [
            'person_name'      => 'required|string|max:255',
            'person_telephone' => 'required|digits:10',
        ];

        $checkout_info = Session::get('checkout_info', []);
        $paymentMethod = session('payment_method', 'pay_now');
        
        if ($checkout_info['delivery_option'] == 'delivery') {
            $rules['person_email'] = auth()->check() ? 'nullable|email:rfc,dns' : 'required|email:rfc,dns';
            $rules['delivery_address'] = 'required|string';
            $rules['latitude'] = 'required';
            $rules['longitude'] = 'required';
        }

        // Validate
        $this->validate($rules);
        $this->updateCheckoutInfo();

        // Get cart items and calculate total
        $cartItems = session('cart', []);
        $subtotal = collect($cartItems)->sum('subtotal');
        $total = $subtotal + $this->delivery;

        // Determine email
        $email = $this->person_email ?: (auth()->check() ? auth()->user()->email : ($checkout_info['guest_email'] ?? ''));
        
        // If payment method is 'pay_on_receive', create order directly without payment
        if ($paymentMethod === 'pay_on_receive') {
            try {
                DB::beginTransaction();

                // Create order
                $order = \App\Models\Order::create([
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'user_id' => auth()->id(),
                    'person_email' => $email,
                    'person_name' => $this->person_name,
                    'person_telephone' => $this->person_telephone,
                    'subtotal' => $subtotal,
                    'delivery_fee' => $this->delivery,
                    'total' => $total,
                    'delivery_option' => $checkout_info['delivery_option'],
                    'delivery_address' => $this->delivery_address ?? null,
                    'payment_method' => $checkout_info['delivery_option'] === 'delivery' ? 'payment_on_delivery' : 'payment_on_pickup',
                    'payment_via' => 'cash',
                    'payment_status' => 'pending',
                    'payment_reference' => null,
                    'order_status' => 'pending',
                    'paid_at' => null,
                ]);

                // Create order items
                foreach ($cartItems as $cartKey => $item) {
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'product_name' => $item['name'],
                        'product_image' => $item['image'] ?? null,
                        'size' => $item['size'] ?? null,
                        'color' => $item['color'] ?? null,
                        'quantity' => $item['qty'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                DB::commit();

                // Clear session data
                session()->forget(['cart', 'delivery_option', 'payment_method', 'checkout_info']);

                return redirect()->route('order.success', $order->id);

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Order creation failed: ' . $e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
                $this->alert('error', 'Failed to create order. Please try again.');
                return;
            }
        }

        // If payment method is 'pay_now', proceed with Paystack payment
        if (!$email) {
            $this->alert('error', 'Email is required for payment');
            return;
        }

        // Initialize Paystack payment
        $paystack = new \App\Services\PaystackService();
        $reference = $paystack->generateReference();

        // Store order info in session for callback
        session([
            'pending_order' => [
                'reference' => $reference,
                'email' => $email,
                'name' => $this->person_name,
                'phone' => $this->person_telephone,
                'cart_items' => $cartItems,
                'subtotal' => $subtotal,
                'delivery' => $this->delivery,
                'total' => $total,
                'delivery_option' => $checkout_info['delivery_option'],
                'delivery_address' => $this->delivery_address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'user_id' => auth()->id(),
                'is_guest' => !auth()->check(),
            ]
        ]);

        // Initialize Paystack transaction
        $result = $paystack->initializeTransaction(
            $email,
            $total,
            $reference,
            [
                'user_id' => auth()->id(),
                'cart_items' => count($cartItems),
                'delivery_option' => $checkout_info['delivery_option'],
            ]
        );

        if ($result['status']) {
            // Redirect to Paystack payment page (external URL)
            $this->redirect($result['authorization_url'], navigate: false);
        } else {
            $this->alert('error', 'Payment initialization failed: ' . $result['message']);
        }
    }

    public function render()
    {
        return view('livewire.home.place-order');
    }
}
