<?php

namespace App\Livewire\Modals;

use Jantinnerezo\LivewireAlert\LivewireAlert;

use Livewire\Component;

// class CartModal extends Component
// {
//   use LivewireAlert;

//   public $cartItems = [];
//   protected $listeners = [
//     'cartUpdated' => 'refreshCart'
//   ];

//   public function mount()
//   {
//     $this->refreshCart();
//   }
//   public function refreshCart()
//   {
//     $this->cartItems = session('cart', []);
//   }

//   public function removeFromCart($productId)
//   {
//     cart()->removeFromCart($productId);
//     $this->refreshCart();
//     $this->dispatch('cartUpdated');
//     $this->alert('success', 'Item removed from cart!');
//   }
//   public function render()
//   {
//     return view('livewire.modals.cart-modal');
//   }
// }
class CartModal extends Component
{
  use LivewireAlert;

  public $cartItems = [];
  public $subtotal;

  protected $listeners = [
    'cartUpdated' => 'refreshCart'
  ];

  public function mount()
  {
    $this->refreshCart();
    // dd($this->cartItems);
  }

  public function refreshCart()
  {
    $this->cartItems = session('cart', []);
    $this->subtotal = collect($this->cartItems)->map(fn($item) => $item['price'] * $item['qty'])->sum();
  }

  public function removeFromCart($cartKey)
  {
    cart()->removeFromCart($cartKey);

    $this->refreshCart();
    $this->dispatch('cartUpdated');

    $this->alert('success', 'Item removed from cart!');
  }

  public function viewCart()
  {
    return redirect()->route('viewCart');
  }

  public function render()
  {
    return view('livewire.modals.cart-modal');
  }
}
