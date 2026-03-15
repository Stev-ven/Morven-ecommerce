<?php

namespace App\Livewire\Shopping;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Details extends Component
{
    use LivewireAlert;
    public $cart_count = 0;
    public $wishlist_count = 0;
    
    protected $listeners = [
        'cartUpdated' => 'refreshCartCount',
        'wishlistUpdated' => 'refreshWishlistCount',
    ];

    public function refreshCartCount()
    {
        $cart = session()->get('cart', []);
        $this->cart_count = collect($cart)->sum('qty');
    }

    public function refreshWishlistCount()
    {
        if (Auth::check()) {
            $this->wishlist_count = Wishlist::where('user_id', Auth::id())->count();
        } else {
            $this->wishlist_count = 0;
        }
    }

    public function render()
    {
        return view('livewire.shopping.details');
    }

    public function mount()
    {
        $this->refreshCartCount();
        $this->refreshWishlistCount();
    }

    public function openCart()
    {
        $products = session()->get('cart', []);
        if (!$products) {
            $this->alert('error', 'Cart is empty, please add items to cart first.');
            return;
        }
        $this->dispatch('open-modal', product: $products, component: 'modals.cart-modal');
    }

    public function openWishlist()
    {
        if (!Auth::check()) {
            $this->alert('error', 'Please login to view your wishlist.');
            $this->dispatch('showLoginModal');
            return;
        }
        
        return redirect()->route('wishlist.index');
    }
}
