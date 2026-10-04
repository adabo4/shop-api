<?php

namespace App\OpenApi\Schemas\Category;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'StoreCategoryRequest',
    type: 'object',
    required: ['name'],
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            maxLength: 255,
            example: 'Zdravie a lieky'
        ),
        new OA\Property(
            property: 'parent_id',
            type: 'integer',
            nullable: true,
            example: null
        ),
    ]
)]
class StoreCategoryRequestSchema {}
