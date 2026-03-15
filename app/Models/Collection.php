<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';
    protected $fillable = [
                        'title', 
                        'collection_image_1',
                        'collection_image_2',
                        'collection_image_3',
                        ];
}
