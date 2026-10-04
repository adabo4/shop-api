<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        return response()->json($product);
    }

    /* POST REQUEST */

    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);
        return response()->json($product);
    }
}
