<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ImageGroup;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CartService
{
  protected string $sessionKey = 'cart';

  public function get(): array
  {
    return Session::get($this->sessionKey, []);
  }

  public function addToCart(int $productId, int $qty = 1, ?string $size = null, ?string $color = null): void
  {
    $qty = max(1, $qty);

    $cart = $this->get();

    $product = Product::with('image_groups')->findOrFail($productId);

    $image = optional($product->image_groups)->image_1;

    // Define categories/subcategories that don't need color/size
    $noColorSizeCategories = ['grooming', 'accessories'];
    $noColorSizeSubcategories = ['cologne', 'perfumes', 'hair products', 'skincare', 'beard care', 'body care', 'watches', 'belts', 'wallets', 'sunglasses', 'jewelry'];
    
    $needsColorSize = !in_array($product->category, $noColorSizeCategories) && 
                      !in_array($product->subcategory, $noColorSizeSubcategories);

    // Create a unique cart key based on product ID, size, and color (only if needed)
    $cartKey = $productId;
    if ($needsColorSize && ($size || $color)) {
      $cartKey = $productId . '_' . ($size ?? 'nosize') . '_' . ($color ?? 'nocolor');
    }

    if (!isset($cart[$cartKey])) {
      $cart[$cartKey] = [
        'product_id'         => $product->id,
        'name'               => $product->name,
        'color'              => $needsColorSize ? ($color ?? ($product->colors[0] ?? null)) : null,
        'size'               => $needsColorSize ? ($size ?? ($product->sizes[0] ?? null)) : null,
        'price'              => $product->price,
        'qty'                => 0,
        'available_quantity' => $product->quantity,
        'subtotal'           => 0,
        'image'              => $image,
      ];
    }

    // Clamp quantity to available stock
    $cart[$cartKey]['qty'] = min(
      $cart[$cartKey]['qty'] + $qty,
      $cart[$cartKey]['available_quantity']
    );

    // Recalculate subtotal
    $cart[$cartKey]['subtotal'] =
      $cart[$cartKey]['qty'] * $cart[$cartKey]['price'];

    Session::put($this->sessionKey, $cart);
  }

  public function removeFromCart(string $cartKey): void
  {
    $cart = $this->get();
    
    // Try to remove by exact key first
    if (isset($cart[$cartKey])) {
      unset($cart[$cartKey]);
      Session::put($this->sessionKey, $cart);
      return;
    }
    
    // Fallback: if it's just a product ID, remove all variants
    foreach ($cart as $key => $item) {
      if ($item['product_id'] == $cartKey) {
        unset($cart[$key]);
      }
    }
    
    Session::put($this->sessionKey, $cart);
  }

  public function clear(): void
  {
    Session::forget($this->sessionKey);
  }

  public function count(): int
  {
    return collect($this->get())->sum('qty');
  }

  public function total(): float
  {
    return collect($this->get())->sum('subtotal');
  }

  public function updateQuantity(int $productId, int $qty): void
  {
    $cart = $this->get();

    if (!isset($cart[$productId])) {
      return;
    }

    $cart[$productId]['qty'] = min(
      max(1, $qty),
      $cart[$productId]['available_quantity']
    );

    $cart[$productId]['subtotal'] =
      $cart[$productId]['qty'] * $cart[$productId]['price'];

    Session::put($this->sessionKey, $cart);
  }

  public function updateSize(int $productId, string|int $size): void
  {
    $cart = $this->get();

    // Ensure product exists in cart
    if (! isset($cart[$productId])) {
      return;
    }

    // Ensure available_sizes exists and size is valid
    if (
      isset($cart[$productId]['available_sizes']) &&
      ! in_array($size, $cart[$productId]['available_sizes'], true)
    ) {
      return;
    }

    // Update size
    $cart[$productId]['size'] = $size;

    // Subtotal stays qty * price (size does not affect price here)
    $cart[$productId]['subtotal'] =
      $cart[$productId]['qty'] * (float) $cart[$productId]['price'];

    // Save back to session
    Session::put($this->sessionKey, $cart);
  }

  public function updateColor(int $productId, string $color): void
  {
    $cart = $this->get();

    // Ensure product exists in cart
    if (! isset($cart[$productId])) {
      return;
    }

    // Validate that the color exists in available_colors
    if (
      isset($cart[$productId]['available_colors']) &&
      ! in_array($color, $cart[$productId]['available_colors'], true)
    ) {
      return;
    }

    // Update color
    $cart[$productId]['color'] = $color;

    // Subtotal stays the same
    $cart[$productId]['subtotal'] =
      $cart[$productId]['qty'] * (float) $cart[$productId]['price'];

    // Save back to session
    Session::put($this->sessionKey, $cart);
  }

  public function placeOrder()
  {
    $validatedUserDetails = Validator::make([
      'person_detail' => [
        'name' => 'required|string',
        'mobile_number' => 'required|numeric|digits:10',
        'email' => 'nullable|email',
      ],
      'order_details' => [
        'items' => [],
        'delivery_address' => [
          'address' => 'required|string',
          'latitude' => 'required',
          'longitude' => 'required'
        ]
      ]

    ]);
  }
}
