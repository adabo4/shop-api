<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UpdateProductRequest',
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            example: 'Paralen 500 mg'
        ),
        new OA\Property(
            property: 'ean',
            type: 'string',
            nullable: true,
            example: '8584005310017'
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
            enum: ['human_medicine', 'food_supplement']
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
    ],
    type: 'object'
)]
class UpdateProductRequestSchema {}
