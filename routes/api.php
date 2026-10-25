
<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PRODUCTS
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('can:products.create');

    Route::patch('/products/{product}', [ProductController::class, 'update'])
        ->middleware('can:products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:products.delete');
});

/*
|--------------------------------------------------------------------------
| CATEGORIES
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/categories', [CategoryController::class, 'store'])
        ->middleware('can:categories.create');

    Route::patch('/categories/{category}', [CategoryController::class, 'update'])
        ->middleware('can:categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->middleware('can:categories.delete');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Authenticated users
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| PASSWORD RESET
|--------------------------------------------------------------------------
*/

Route::post(
    '/auth/forgot-password',
    [PasswordResetController::class, 'forgotPassword']
)->middleware('throttle:5,1');

Route::post(
    '/auth/reset-password',
    [PasswordResetController::class, 'resetPassword']
)->middleware('throttle:5,1');
