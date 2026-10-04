<?php

namespace App\OpenApi\Schemas\Category;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UpdateCategoryRequest',
    type: 'object',
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            maxLength: 255,
            example: 'Bolesť a horúčka'
        ),
        new OA\Property(
            property: 'parent_id',
            type: 'integer',
            nullable: true,
            example: 1
        ),
    ]
)]
class UpdateCategoryRequestSchema {}
