<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;


class ProductController extends Controller
{
    #[OA\Get(
        path: '/api/products',
        summary: 'Get all products',
        tags: ['Products'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of products',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/Product'
                    )
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        $products = Product::query()
            ->where('is_active', true)
            ->get();

        return response()->json($products);
    }

    #[OA\Get(
        path: '/api/products/{slug}',
        summary: 'Get product by slug',
        tags: ['Products'],
        parameters: [
            new OA\Parameter(
                name: 'slug',
                in: 'path',
                required: true,
                description: 'Product Slug',
                schema: new OA\Schema(type: 'string'),
                example: 'paralen-500'
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Product detail',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 2),
                        new OA\Property(property: 'product_code', type: 'string', example: 'VIT-000002'),
                        new OA\Property(
                            property: 'name',
                            type: 'string',
                            example: 'Testovací výživový doplnok'
                        ),
                        new OA\Property(
                            property: 'slug',
                            type: 'string',
                            example: 'testovaci-vyzivovy-doplnok'
                        ),
                        new OA\Property(property: 'ean', type: 'string', nullable: true),
                        new OA\Property(property: 'sukl_code', type: 'string', nullable: true),
                        new OA\Property(
                            property: 'product_type',
                            type: 'string',
                            example: 'food_supplement'
                        ),
                        new OA\Property(
                            property: 'price',
                            type: 'string',
                            example: '12.50'
                        ),
                        new OA\Property(property: 'is_active', type: 'boolean', example: true),
                        new OA\Property(property: 'description', type: 'string', nullable: true),
                        new OA\Property(property: 'composition', type: 'string', nullable: true),
                        new OA\Property(property: 'dosage', type: 'string', nullable: true),
                        new OA\Property(property: 'usage', type: 'string', nullable: true),
                        new OA\Property(property: 'warnings', type: 'string', nullable: true),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Product not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Product not found.'
                        ),
                    ]
                )
            ),
        ]
    )]

    public function show(string $slug): JsonResponse
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$product) {
            return response()->json(['message=> "Product not found."', 404]);
        }

        return response()->json($product);
    }
}
