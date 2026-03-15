<?php

namespace App\Livewire\Home;

use Livewire\Component;

class Collection extends Component
{   
    public $collection;
    public $products;
    public function render()
    {
        // dd($this->products);
        return view('livewire.home.collection');
    }
}
