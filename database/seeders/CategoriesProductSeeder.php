<?php

namespace Database\Seeders;

use App\Models\CategoriesProduct;
use Illuminate\Database\Seeder;

class CategoriesProductSeeder extends Seeder
{
    public function run()
    {
        $beautyProducts = [
            [
                'slug' => 'beauty-1',
                'name' => 'Luxury Facial Cream',
                'url' => 'https://dummyjson.com/products/beauty/1',
                'description' => 'Premium facial cream with natural ingredients',
                'price' => 49.99,
                'discount_percentage' => 10.00,
                'rating' => 4.7,
                'stock' => 100,
                'brand' => 'Luxury Beauty',
                'thumbnail' => 'https://dummyjson.com/image/300x300/beauty/1.jpg',
                'images' => json_encode([
                    'https://dummyjson.com/image/300x300/beauty/1-1.jpg',
                    'https://dummyjson.com/image/300x300/beauty/1-2.jpg'
                ])
            ],
            [
                'slug' => 'beauty-2',
                'name' => 'Anti-Aging Serum',
                'url' => 'https://dummyjson.com/products/beauty/2',
                'description' => 'Advanced anti-aging serum with retinol',
                'price' => 79.99,
                'discount_percentage' => 15.00,
                'rating' => 4.9,
                'stock' => 75,
                'brand' => 'Youthful',
                'thumbnail' => 'https://dummyjson.com/image/300x300/beauty/2.jpg',
                'images' => json_encode([
                    'https://dummyjson.com/image/300x300/beauty/2-1.jpg',
                    'https://dummyjson.com/image/300x300/beauty/2-2.jpg'
                ])
            ]
        ];

        foreach ($beautyProducts as $product) {
            CategoriesProduct::create($product);
        }
    }
}
