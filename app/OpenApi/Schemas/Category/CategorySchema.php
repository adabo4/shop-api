<?php

namespace App\OpenApi\Schemas\Category;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Category',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'name',
            type: 'string',
            example: 'Zdravie a lieky'
        ),
        new OA\Property(
            property: 'slug',
            type: 'string',
            example: 'zdravie-a-lieky'
        ),
        new OA\Property(
            property: 'parent_id',
            type: 'integer',
            nullable: true,
            example: null
        ),
        new OA\Property(
            property: 'children',
            type: 'array',
            items: new OA\Items(
                ref: '#/components/schemas/Category'
            )
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time'
        ),
    ]
)]
class CategorySchema {}
