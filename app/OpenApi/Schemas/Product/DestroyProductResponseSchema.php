<?php

namespace App\OpenApi\Schemas\Product;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'DestroyProductResponse',
    type: 'object',
    required: ['message'],
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Product deleted successfully.'
        ),
    ]
)]
class DestroyProductResponseSchema {}
