<?php

namespace App\Livewire\Home;

use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Kids extends Component
{   
    use LivewireAlert;
    
    public $all_kids_products;
    public function get_all_products(){
        $this->all_kids_products = Product::with('image_groups')
            ->where('category', 'kids')
            ->get()
            ->toArray();
    }

    public function viewProduct($product_id){
        $product = Product::with('image_groups')->find($product_id);
        if (!$product) {
            $this->alert('error', 'Product not found');
            return;
        }
        $this->dispatch('open-modal', product: $product->toArray(), component: 'modals.product-modal');
    }
    public function render()
    {   
        $this->get_all_products();
        return view('livewire.home.kids');
    }
}
