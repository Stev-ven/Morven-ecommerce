<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductSearch extends Component
{
    public $search = '';
    public $results = [];
    public $showResults = false;

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->results = Product::where('name', 'like', "%{$this->search}%")
                ->orWhere('category', 'like', "%{$this->search}%")
                ->orWhere('subcategory', 'like', "%{$this->search}%")
                ->orWhere('brand', 'like', "%{$this->search}%")
                ->with('image_groups')
                ->limit(8)
                ->get();
            $this->showResults = true;
        } else {
            $this->results = [];
            $this->showResults = false;
        }
    }

    public function viewProduct($product_id)
    {
        // Always redirect to product details page for search results
        // This provides a better experience for both mobile and desktop
        $this->closeSearch();
        return redirect()->route('product_details', $product_id);
    }

    public function closeSearch()
    {
        $this->search = '';
        $this->results = [];
        $this->showResults = false;
        $this->dispatch('close-search-modal');
    }

    public function render()
    {
        return view('livewire.product-search');
    }
}
