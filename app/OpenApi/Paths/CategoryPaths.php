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

    #[OA\Get(
        path: '/api/categories/{slug}',
        summary: 'Get category by slug',
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(
                name: 'slug',
                in: 'path',
                required: true,
                description: 'Category slug',
                schema: new OA\Schema(
                    type: 'string',
                    example: 'zdravie-a-lieky'
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Category detail',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/Category'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Category not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Category not found.'
                        )
                    ]
                )
            )
        ]
    )]

    public function index(): void {}

    #[OA\Post(
        path: '/api/categories',
        summary: 'Create a category',
        tags: ['Categories'],
        security: [['sessionAuth' => []]],
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
                response: 401,
                description: 'Unauthenticated.'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden. Insufficient permissions.'
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
        security: [['sessionAuth' => []]],
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
                response: 401,
                description: 'Unauthenticated.'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden. Insufficient permissions.'
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

    #[OA\Delete(
        path: '/api/categories/{category}',
        summary: 'Delete a category',
        tags: ['Categories'],
        security: [['sessionAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'category',
                in: 'path',
                required: true,
                description: 'Category ID',
                schema: new OA\Schema(
                    type: 'integer',
                    example: 3
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Category deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Category deleted successfully.'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated.'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden. Insufficient permissions.'
            ),
            new OA\Response(
                response: 404,
                description: 'Category not found'
            ),
            new OA\Response(
                response: 409,
                description: 'Category has subcategories and cannot be deleted',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Category cannot be deleted because it has subcategories.'
                        )
                    ]
                )
            )
        ]
    )]

    public function store(): void {}
}
