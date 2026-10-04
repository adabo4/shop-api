<?php

namespace App\OpenApi\Schemas\Product;

use OpenApi\Attributes as OA;

/*Swagger response schema v odpovede v docs */

#[OA\Schema(
    schema: 'Product',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 2),
        new OA\Property(property: 'product_code', type: 'string', example: 'VIT-000002'),
        new OA\Property(property: 'name', type: 'string', example: 'Testovací výživový doplnok'),
        new OA\Property(property: 'slug', type: 'string', example: 'testovaci-vyzivovy-doplnok'),
        new OA\Property(property: 'ean', type: 'string', nullable: true, example: '8580000000002'),
        new OA\Property(property: 'sukl_code', type: 'string', nullable: true),
        new OA\Property(property: 'product_type', type: 'string', example: 'food_supplement'),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(property: 'description', type: 'string', nullable: true),
        new OA\Property(property: 'composition', type: 'string', nullable: true),
        new OA\Property(property: 'dosage', type: 'string', nullable: true),
        new OA\Property(property: 'usage', type: 'string', nullable: true),
        new OA\Property(property: 'warnings', type: 'string', nullable: true),
    ]
)]
class ProductSchema {}
