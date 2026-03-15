<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Collection;
use App\Models\ProductCards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function homepage()
    {
        $main_product_cards = ProductCards::where('is_main', true)->get();
        $sub_product_cards = ProductCards::where('is_main', false)->get();
        $page_content = [
            'main_product_cards' => $main_product_cards,
            'sub_product_cards' => $sub_product_cards,
        ];
        return view('home', compact('page_content'));
    }

    public function viewMen()
    {
        return view('home.men');
    }

    public function viewSneakers(){
        return view('home.sneakers');
    }
    public function viewAccessories(){
        return view('home.accessories');
    }

    public function viewWomen()
    {
        return view('home.women');
    }

    public function viewKids()
    {
        return view('home.kids');
    }

    // New category pages
    public function viewClothing()
    {
        return view('home.category-wrapper', [
            'category' => 'Clothing',
            'categorySlug' => 'clothing'
        ]);
    }

    public function viewFootwear()
    {
        return view('home.category-wrapper', [
            'category' => 'Footwear',
            'categorySlug' => 'footwear'
        ]);
    }

    public function viewAccessoriesCategory()
    {
        return view('home.category-wrapper', [
            'category' => 'Accessories',
            'categorySlug' => 'accessories'
        ]);
    }

    public function viewActivewear()
    {
        return view('home.category-wrapper', [
            'category' => 'Activewear',
            'categorySlug' => 'activewear'
        ]);
    }

    public function viewGrooming()
    {
        return view('home.category-wrapper', [
            'category' => 'Grooming',
            'categorySlug' => 'grooming'
        ]);
    }

    public function viewCollection($id)
    {
        $collection = Collection::findOrFail($id);
        //match products related to collection
        $products = Product::where('name', 'like', '%' . $collection->title . '%')
            ->orWhere('subcategory', 'like', '%' . $collection->title . '%')
            ->get();
        return view('home.collection', compact('collection', 'products'));
    }
}
