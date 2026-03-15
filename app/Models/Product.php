<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'image_group_id',
        'name',
        'description',
        'price',
        'quantity',
        'category',
        'subcategory',
        'colors',
        'brand',
        'sizes',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array'
    ];
    // belongs to image group
    public function image_groups()
    {
        return $this->belongsTo(ImageGroup::class, 'image_group_id');
    }

    //has one collection
    public function collections()
    {
        return $this->hasOne(Collection::class);
    }

   
}
