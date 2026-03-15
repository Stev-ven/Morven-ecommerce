<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCards extends Model
{
    protected $table = 'product_cards';
    protected $fillable = [
        'title',
        'collection_image1',
        'collection_image2',
        'collection_image3',
        'image_path',
        'is_main',
    ];
    
    //has many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    
}
