<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductCard extends Component
{
    public $pageContent;

    /**
     * Create a new component instance.
     *
     * @param mixed $pageContent
     */
    public function __construct($pageContent)
    {
        $this->pageContent = $pageContent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product-card', [
            'page_content' => $this->pageContent
        ]);
    }
}