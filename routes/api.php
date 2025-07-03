<?php
// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoriesProductController;
use App\Http\Controllers\Api\CartController;

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('user-profile', [AuthController::class, 'userProfile']);
    });
});

Route::group(['middleware' => 'auth:api'], function() {

    // User Management (Admin only)
    Route::get('users', [AuthController::class, 'index']);
    Route::get('users/{id}', [AuthController::class, 'show']);
    Route::post('users', [AuthController::class, 'register']);

    // Products
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    // Categories Products
    Route::get('categories', [CategoriesProductController::class, 'index']);
    Route::get('categories/{id}', [CategoriesProductController::class, 'show']);
    Route::post('categories', [CategoriesProductController::class, 'store']);
    Route::put('categories/{id}', [CategoriesProductController::class, 'update']);

    // cart
    Route::get('cart', [CartController::class, 'show']);
    Route::post('cart/add', [CartController::class, 'addToCart']);

});
