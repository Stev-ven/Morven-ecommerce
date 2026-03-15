<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageGroup extends Model
{
    protected $table = 'image_groups';
    protected $fillable = [
        'name',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
    ];

    //has many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
