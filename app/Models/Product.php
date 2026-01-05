<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'category',
        'color',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
    ];
}
