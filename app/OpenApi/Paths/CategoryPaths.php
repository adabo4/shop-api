<?php

namespace App\OpenApi\Paths;

use OpenApi\Attributes as OA;

class CategoryPaths
{
    #[OA\Get(
        path: '/api/categories',
        summary: 'Get all categories',
        tags: ['Categories'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of categories',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/Category'
                    )
                )
            )
        ]
    )]
    public function index(): void {}

    #[OA\Post(
        path: '/api/categories',
        summary: 'Create a category',
        tags: ['Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/StoreCategoryRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Category created successfully',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Category'
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]

    #[OA\Patch(
        path: '/api/categories/{category}',
        summary: 'Update a category',
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(
                name: 'category',
                in: 'path',
                required: true,
                description: 'Category ID',
                schema: new OA\Schema(
                    type: 'integer',
                    example: 2
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/UpdateCategoryRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Category updated successfully',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Category'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Category not found'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]

    public function store(): void {}
}
