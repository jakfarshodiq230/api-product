<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'title' => 'Nike JA 1 mismatch',
                'description' => 'Nike Ja Morant shoes gen 1 mismatch type',
                'category' => 'mens-shoes',
                'price' => 399.99,
                'brand' => 'Nike',
                'stock' => 5,
                'created_at' => now(),
                'updated_at' => now(),

                // Optional fields with default values
                'discount_percentage' => null,
                'rating' => null,
                'tags' => json_encode(['nike', 'basketball', 'ja-morant']),
                'sku' => 'NIKE-JA1-MM-001',
                'weight' => 1.2,
                'dimensions' => json_encode([
                    'width' => 12,
                    'height' => 6,
                    'depth' => 20
                ]),
                'warranty_information' => '1 year manufacturer warranty',
                'shipping_information' => 'Ships in 1-3 business days',
                'availability_status' => 'Low Stock',
                'reviews' => json_encode([]),
                'return_policy' => '30 days return policy',
                'minimum_order_quantity' => 1,
                'meta' => json_encode([
                    'createdAt' => now()->toISOString(),
                    'updatedAt' => now()->toISOString(),
                    'barcode' => '1234567890123'
                ]),
                'images' => json_encode([
                    'https://example.com/images/nike-ja1-mismatch-1.jpg',
                    'https://example.com/images/nike-ja1-mismatch-2.jpg'
                ]),
                'thumbnail' => 'https://example.com/images/nike-ja1-mismatch-thumbnail.jpg'
            ]
        ]);
    }
}
