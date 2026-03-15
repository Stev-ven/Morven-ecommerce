<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ModalManager extends Component
{   
    public bool $open = false;
    public ?string $component = null;
    public array $product = [];

    #[On('open-modal')]
    public function show($product = [], $component = null)
    {
        $this->open = true;
        $this->component = $component;
        $this->product = $product;
    }

    #[On('close-modal')]
    public function hide()
    {
        $this->open = false;
        $this->component = null;
        $this->product = [];
    }
    public function render()
    {
        return view('livewire.modal-manager');
    }
}
