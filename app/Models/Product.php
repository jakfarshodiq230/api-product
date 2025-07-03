<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'price',
        'discountPercentage',
        'rating',
        'stock',
        'tags',
        'brand',
        'sku',
        'weight',
        'dimensions',
        'warrantyInformation',
        'shippingInformation',
        'availabilityStatus',
        'reviews',
        'returnPolicy',
        'minimumOrderQuantity',
        'images',
        'thumbnail',
        'meta'
    ];

    protected $casts = [
        'tags' => 'array',
        'dimensions' => 'array',
        'reviews' => 'array',
        'images' => 'array',
        'meta' => 'array'
    ];
}
