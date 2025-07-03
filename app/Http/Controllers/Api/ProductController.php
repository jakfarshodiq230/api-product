<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $skip = 0;
        $limit = 30;
        $total = Product::count();
        $products = Product::skip($skip)
            ->take($limit)
            ->get();
        return response()->json([
            'message' => 'Daftar produk berhasil diambil',
            'products' => $products,
            'total' => $total,
            'skip' => $skip,
            'limit' => $limit,
        ], 200);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'category' => 'sometimes|string|max:255',
            'brand' => 'sometimes|string|max:255',
            'stock' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Create Nike JA 1 Mismatch product via API
     */
    public function createNikeJaMismatch()
    {
        $productData = [
            'title' => 'Nike JA 1 mismatch',
            'description' => 'Nike Ja Morant shoes gen 1 mismatch type',
            'price' => 399.99,
            'category' => 'mens-shoes',
            'brand' => 'Nike',
            'stock' => 5
        ];

        $product = Product::create($productData);

        return response()->json([
            'success' => true,
            'message' => 'Nike JA 1 Mismatch product created successfully',
            'data' => $product
        ], 201);
    }
}
