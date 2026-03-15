<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Collection;

class Collections extends Component
{   
    public $collections;
    public function getCollections(){
        $this->collections = Collection::all()->toArray();
    }
    public function render()
    {   
        $this->getCollections();
        return view('livewire.products.collections');
    }
}
