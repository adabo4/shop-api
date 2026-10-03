<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Product',
    title: 'Product',
    description: 'Vitalis Shop Product',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'product_code',
            type: 'string',
            example: 'VIT-001'
        ),
        new OA\Property(
            property: 'name',
            type: 'string',
            example: 'Paralen 500'
        ),
        new OA\Property(
            property: 'slug',
            type: 'string',
            example: 'paralen-500'
        ),
        new OA\Property(
            property: 'ean',
            type: 'string',
            nullable: true,
            example: '8584005010012'
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
            example: 'MEDICINE'
        ),
        new OA\Property(
            property: 'price',
            type: 'string',
            example: '4.99'
        ),
        new OA\Property(
            property: 'is_active',
            type: 'boolean',
            example: true
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Product description'
        ),
        new OA\Property(
            property: 'composition',
            type: 'string',
            nullable: true,
            example: 'Product composition'
        ),
        new OA\Property(
            property: 'dosage',
            type: 'string',
            nullable: true,
            example: 'Product dosage'
        ),
        new OA\Property(
            property: 'usage',
            type: 'string',
            nullable: true,
            example: 'Product usage'
        ),
        new OA\Property(
            property: 'warnings',
            type: 'string',
            nullable: true,
            example: 'Product warnings'
        ),
    ]
)]

class ProductSchema {}
