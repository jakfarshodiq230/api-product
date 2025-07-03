<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cart",
     *     summary="Get user's cart",
     *     tags={"Cart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         description="Number of products to skip",
     *         required=false,
     *         @OA\Schema(type="integer", default=0)
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of products to return",
     *         required=false,
     *         @OA\Schema(type="integer", default=30)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart data",
     *         @OA\JsonContent(
     *             @OA\Property(property="carts", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="products", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="price", type="number", format="float"),
     *                         @OA\Property(property="quantity", type="integer"),
     *                         @OA\Property(property="total", type="number", format="float"),
     *                         @OA\Property(property="discountPercentage", type="number", format="float"),
     *                         @OA\Property(property="discountedTotal", type="number", format="float"),
     *                         @OA\Property(property="thumbnail", type="string"),
     *                     )
     *                 ),
     *                 @OA\Property(property="total", type="number", format="float"),
     *                 @OA\Property(property="discountedTotal", type="number", format="float"),
     *                 @OA\Property(property="userId", type="integer"),
     *                 @OA\Property(property="totalProducts", type="integer"),
     *                 @OA\Property(property="totalQuantity", type="integer"),
     *             ),
     *             @OA\Property(property="total", type="integer"),
     *             @OA\Property(property="skip", type="integer"),
     *             @OA\Property(property="limit", type="integer"),
     *         )
     *     )
     * )
     */
    // Get user's cart
    public function show(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with(['items.product'])->firstOrCreate(['user_id' => $user->id]);

        // Get skip and limit from query, default to 0 and 10
        $skip = (int) $request->query('skip', 0);
        $limit = (int) $request->query('limit', 30);

        $products = $cart->items->map(function ($item) {
            $product = $item->product;
            $quantity = $item->quantity;
            $price = $product->price;
            $discountPercentage = $product->discount_percentage ?? 0;
            $totalPrice = $price * $quantity;
            $discountedUnitPrice = $price - ($price * $discountPercentage / 100);
            $discountedPrice = $discountedUnitPrice * $quantity;

            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $price,
                'quantity' => $quantity,
                'total' => round($totalPrice, 2),
                'discountPercentage' => round($discountPercentage, 2),
                'discountedTotal' => round($discountedPrice, 2),
                'thumbnail' => $product->thumbnail,
            ];
        });

        $totalProducts = $products->count();
        $totalQuantity = $cart->items->sum('quantity');
        $total = $products->sum('total');
        $discountedTotal = $products->sum('discountedTotal');

        // Apply skip and limit
        $pagedProducts = $products->slice($skip, $limit)->values();

        return response()->json([
            'carts' => [
                'id' => $cart->id,
                'products' => $pagedProducts,
                'total' => round($total, 2),
                'discountedTotal' => round($discountedTotal, 2),
                'userId' => $cart->user_id,
                'totalProducts' => $totalProducts,
                'totalQuantity' => $totalQuantity,
            ],
            'total' => $totalProducts,
            'skip' => $skip,
            'limit' => $limit,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/cart/add",
     *     summary="Add items to cart",
     *     tags={"Cart"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"userId","products"},
     *             @OA\Property(property="userId", type="integer", example=1),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Products added to cart successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="cart", type="object"),
     *             @OA\Property(property="items", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="total", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    // Add items to cart
    public function addToCart(Request $request)
    {
        try {
            $validated = $request->validate([
                'userId' => 'required|exists:users,id',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['id']);

            // Check if product already exists in cart
            $existingItem = $cart->items()->where('product_id', $product->id)->first();

            if ($existingItem) {
                // Update quantity if product already in cart
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $productData['quantity']
                ]);
            } else {
                // Add new item to cart
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity']
                ]);
            }
        }

        $cart->load('items.product');

        return response()->json([
            'message' => 'Products added to cart successfully',
            'cart' => $cart,
            'items' => $cart->items,
            'total' => $this->calculateTotal($cart)
        ], 201);
    }

    // Helper method to calculate cart total
    private function calculateTotal(Cart $cart): float
    {
        $total = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            $total += ($product->price * $item->quantity);

            if ($product->discount_percentage) {
                $total -= ($product->price * $item->quantity * $product->discount_percentage / 100);
            }
        }

        return round($total, 2);
    }
}
