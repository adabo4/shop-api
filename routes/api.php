<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{slug}', [ProductController::class, 'show']);

Route::post('products', [ProductController::class, 'store']);
Route::patch('products/{product}', [ProductController::class, 'update']);

Route::delete('products/{product}', [ProductController::class, 'destroy']);

/* CATEGORY */

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PasswordResetController;

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

Route::post('/categories', [CategoryController::class, 'store']);
Route::patch('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::post(
    '/auth/forgot-password',
    [PasswordResetController::class, 'forgotPassword']
)->middleware('throttle:5,1');

Route::post(
    '/auth/reset-password',
    [PasswordResetController::class, 'resetPassword']
)->middleware('throttle:5,1');
