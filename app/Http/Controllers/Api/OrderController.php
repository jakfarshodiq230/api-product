<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index() {
        $orders = Order::with('items.product')->get();
        return response()->json($orders);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $items = $request->items;
        $totalAmount = 0;
        $orderItems = [];

        // Check product availability and calculate total
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'message' => 'Insufficient stock for product: ' . $product->name
                ], 400);
            }

            $subtotal = $product->price * $item['quantity'];
            $totalAmount += $subtotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price
            ];
        }

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);

        // Create order items and update product stock
        foreach ($orderItems as $item) {
            $order->items()->create($item);

            $product = Product::find($item['product_id']);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order->load('items.product')
        ], 201);
    }

    public function show($id) {
        $order = Order::with('items.product')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
}
