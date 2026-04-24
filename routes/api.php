<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopUsersController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/users', UserManagementController::class);
    Route::apiResource('/category-products', CategoryProductController::class);
    Route::apiResource('/shops', ShopController::class);
    Route::apiResource('/products', ProductController::class);

    // Shop Staff Management
    Route::get('/shops/{shop}/staff', [ShopUsersController::class, 'index']);
    Route::post('/shops/{shop}/staff', [ShopUsersController::class, 'store']);
    Route::delete('/shops/{shop}/staff/{user}', [ShopUsersController::class, 'destroy']);
});


