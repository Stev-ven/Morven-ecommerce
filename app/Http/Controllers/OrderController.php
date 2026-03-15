<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{   
    public function myOrders()
    {
        $user_id = Auth::id();
        $orders = Order::with('items')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orders.myorders', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);
        
        return view('orders.details', compact('order'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('items', 'user')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function viewInvoice($id)
    {
        $order = Order::with('items', 'user')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        
        return $pdf->stream('invoice-' . $order->order_number . '.pdf');
    }
}
