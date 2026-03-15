<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Sneakers extends Component
{
    use LivewireAlert;
    public $all_sneakers;



    public function get_all_products()
    {
        $this->all_sneakers = Product::with('image_groups')
            ->where('category', 'men')->where('subcategory', 'sneakers')
            ->get()
            ->toArray();
    }

    public function viewProduct($product_id)
    {

        // dd('test');
        $product = Product::with('image_groups')->find($product_id);
        if (!$product) {
            $this->alert('error', 'Product not found');
        }
        $this->dispatch('open-modal', product: $product->toArray(), component: 'modals.product-modal');
    }
    public function render()
    {
        $this->get_all_products();
        return view('livewire.home.sneakers');
    }
}
