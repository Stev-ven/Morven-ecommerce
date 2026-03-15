<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Accessories extends Component
{
    use LivewireAlert;
    public $all_accessories;



    public function get_all_products()
    {
        $this->all_accessories = Product::with('image_groups')
            ->where('category', 'men')->where('subcategory', 'accessories')
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
        return view('livewire.home.accessories');
    }
}
