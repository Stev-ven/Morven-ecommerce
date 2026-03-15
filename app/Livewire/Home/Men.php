<?php

namespace App\Livewire\Home;

use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Men extends Component
{
    use LivewireAlert;
    public $all_men_products;



    public function get_all_products()
    {
        $this->all_men_products = Product::with('image_groups')
            ->where('category', 'men')
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
        return view('livewire.home.men');
    }
}
