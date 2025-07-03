<?php

// app/Models/BeautyProduct.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesProduct extends Model
{
    use HasFactory;

    protected $table = 'categories_products';

    protected $fillable = [
        'slug',
        'name',
        'url',
        'description',
        'price',
        'discount_percentage',
        'rating',
        'stock',
        'brand',
        'category',
        'thumbnail',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'float',
        'rating' => 'float',
    ];
}
