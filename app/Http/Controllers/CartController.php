<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart($productId)
    {
        $cart[$productId] = ($cart[$productId] ?? 0) + 1;
        session(['cart', []]);
        return back()->with('success', 'Item addedd');
    }

    public function removeFromCart($productId)
    {
        $cart = session('cart', []);

        unset($cart[$productId]);

        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from cart.');
    }

    public function viewCart()
    {
        return view('home.cart-details');
    }

    public function placeOrder()
    {
        return view('home.place-order');
    }

    public function payment()
    {
        return view('home.payment');
    }
}
