<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function payment()
    {

        //got to paystack payment page
    }

    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('home')->with('error', 'Invalid payment reference');
        }

        // Verify payment with Paystack
        $paystack = new PaystackService();
        $result = $paystack->verifyTransaction($reference);

        if (!$result['status']) {
            return redirect()->route('payment')->with('error', 'Payment verification failed');
        }

        // Get pending order from session
        $pendingOrder = session('pending_order');

        if (!$pendingOrder || $pendingOrder['reference'] !== $reference) {
            return redirect()->route('home')->with('error', 'Order not found');
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $pendingOrder['user_id'],
                'person_email' => $pendingOrder['email'],
                'person_name' => $pendingOrder['name'],
                'person_telephone' => $pendingOrder['phone'],
                'subtotal' => $pendingOrder['subtotal'],
                'delivery_fee' => $pendingOrder['delivery'],
                'total' => $pendingOrder['total'],
                'delivery_option' => $pendingOrder['delivery_option'],
                'delivery_address' => $pendingOrder['delivery_address'] ?? null,
                'payment_method' => 'paid_on_order',
                'payment_via' => 'paystack',
                'payment_status' => 'paid',
                'payment_reference' => $reference,
                'order_status' => 'pending',
                'paid_at' => now(),
            ]);

            // Create order items
            foreach ($pendingOrder['cart_items'] as $cartKey => $item) {
                OrderItem::create([
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
            session()->forget(['cart', 'delivery_option', 'pending_order', 'checkout_info']);

            return redirect()->route('order.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('payment')->with('error', 'Failed to create order');
        }
    }


    public function orderSuccess($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        // Ensure user can only view their own orders (or guest orders without user_id)
        if ($order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }
}
