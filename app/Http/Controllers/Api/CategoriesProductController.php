<?php

namespace App\Http\Controllers\Api;

use App\Models\CategoriesProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories-products",
     *     summary="Get list of category products",
     *     tags={"CategoriesProduct"},
     *     @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         description="Number of records to skip",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of records to return",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/categories-products/{id}",
     *     summary="Get a category product by ID",
     *     tags={"CategoriesProduct"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/categories-products",
     *     summary="Create a new category product",
     *     tags={"CategoriesProduct"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"slug","name","url"},
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="url", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="discount_percentage", type="number"),
     *             @OA\Property(property="rating", type="number"),
     *             @OA\Property(property="stock", type="integer"),
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="thumbnail", type="string"),
     *             @OA\Property(property="images", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/categories-products/{id}",
     *     summary="Update a category product",
     *     tags={"CategoriesProduct"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="url", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="discount_percentage", type="number"),
     *             @OA\Property(property="rating", type="number"),
     *             @OA\Property(property="stock", type="integer"),
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="thumbnail", type="string"),
     *             @OA\Property(property="images", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/categories-products/{id}",
     *     summary="Delete a category product",
     *     tags={"CategoriesProduct"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
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
