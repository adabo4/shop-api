<?php

namespace App\OpenApi\Schemas\Product;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CreateProductRequest',
    type: 'object',
    required: [
        'name',
        'product_type',
    ],
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            example: 'Paralen 500'
        ),
        new OA\Property(
            property: 'ean',
            type: 'string',
            nullable: true,
            example: '8580000000003'
        ),
        new OA\Property(
            property: 'sukl_code',
            type: 'string',
            nullable: true,
            example: '12345'
        ),
        new OA\Property(
            property: 'product_type',
            type: 'string',
            enum: ['human_medicine', 'food_supplement'],
            example: 'human_medicine'
        ),
        new OA\Property(
            property: 'is_active',
            type: 'boolean',
            example: true
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true
        ),
        new OA\Property(
            property: 'composition',
            type: 'string',
            nullable: true
        ),
        new OA\Property(
            property: 'dosage',
            type: 'string',
            nullable: true
        ),
        new OA\Property(
            property: 'usage',
            type: 'string',
            nullable: true
        ),
        new OA\Property(
            property: 'warnings',
            type: 'string',
            nullable: true
        ),
    ]
)]
class CreateProductRequestSchema {}
