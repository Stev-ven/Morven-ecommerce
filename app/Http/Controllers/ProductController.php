<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function viewProduct($product_id){
        // $product = Product::with('image_groups')->find($product_id);
        // if(empty($product)){
            
        //     return redirect()->back()->with('error', 'Product not found');
        // }
        return view('products.product_details', ['product_id' => $product_id]);
    }
}
