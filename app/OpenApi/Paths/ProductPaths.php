<?php

namespace App\OpenApi\Paths;

use OpenApi\Attributes as OA;

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
        ),
    ]
)]
#[OA\Get(
    path: '/api/products/{slug}',
    summary: 'Get product by slug',
    tags: ['Products'],
    parameters: [
        new OA\Parameter(
            name: 'slug',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'string'),
            example: 'testovaci-vyzivovy-doplnok'
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Product detail',
            content: new OA\JsonContent(
                ref: '#/components/schemas/Product'
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

#[OA\Post(
    path: '/api/products',
    summary: 'Create product',
    tags: ['Products'],

    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: '#/components/schemas/CreateProductRequest'
        )
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: 'Product created successfully',
            content: new OA\JsonContent(
                ref: '#/components/schemas/Product'
            )
        ),

        new OA\Response(
            response: 422,
            description: 'Validation error'
        ),
    ]

)]

#[OA\Patch(
    path: '/api/products/{product}',
    summary: 'Update a product',
    tags: ['Products'],
    parameters: [
        new OA\Parameter(
            name: 'product',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: '#/components/schemas/UpdateProductRequest'
        )
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'Product updated successfully',
            content: new OA\JsonContent(
                ref: '#/components/schemas/Product'
            )
        ),
        new OA\Response(
            response: 404,
            description: 'Product not found'
        ),
        new OA\Response(
            response: 422,
            description: 'Validation error'
        ),
    ]
)]

#[OA\Delete(
    path: '/api/products/{product}',
    summary: 'Delete product',
    tags: ['Products'],
    parameters: [
        new OA\Parameter(
            name: 'product',
            in: 'path',
            required: true,
            description: 'Product ID',
            schema: new OA\Schema(
                type: 'integer',
                example: 6
            )
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Product deleted successfully',
            content: new OA\JsonContent(
                ref: '#/components/schemas/DestroyProductResponse'
            )
        ),
        new OA\Response(
            response: 404,
            description: 'Product not found'
        ),
    ]
)]

class ProductPaths {}
