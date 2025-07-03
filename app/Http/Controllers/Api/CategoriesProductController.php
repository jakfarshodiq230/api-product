<?php

namespace App\Http\Controllers\Api;

use App\Models\CategoriesProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesProductController extends Controller
{
    public function index()
    {
        $skip = 0;
        $limit = 30;
        $total = CategoriesProduct::count();
        $products = CategoriesProduct::skip($skip)
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

    public function show($id)
    {
        $product = CategoriesProduct::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|unique:categories_products',
            'name' => 'required',
            'url' => 'required|url',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'discount_percentage' => 'nullable|numeric',
            'rating' => 'nullable|numeric|between:0,5',
            'stock' => 'nullable|integer',
            'brand' => 'nullable',
            'thumbnail' => 'nullable|url',
            'images' => 'nullable|json'
        ]);

        $product = CategoriesProduct::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = CategoriesProduct::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'slug' => 'sometimes|required|unique:beauty_products,slug,'.$id,
            'name' => 'sometimes|required',
            'url' => 'sometimes|required|url',
            'description' => 'nullable',
            'price' => 'sometimes|required|numeric',
            'discount_percentage' => 'nullable|numeric',
            'rating' => 'nullable|numeric|between:0,5',
            'stock' => 'sometimes|required|integer',
            'brand' => 'nullable',
            'thumbnail' => 'nullable|url',
            'images' => 'nullable|json'
        ]);

        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = CategoriesProduct::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ]);
    }
}
