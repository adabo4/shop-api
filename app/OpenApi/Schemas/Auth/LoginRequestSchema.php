<?php

namespace App\OpenApi\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LoginRequest',
    title: 'Login Request',
    description: 'Credentials required to log in an existing customer.',
    required: [
        'email',
        'password',
    ],
    properties: [
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            example: 'test@example.sk'
        ),
        new OA\Property(
            property: 'password',
            type: 'string',
            format: 'password',
            writeOnly: true,
            example: 'MojeHeslo123'
        ),
    ],
    type: 'object'
)]
class LoginRequestSchema {}
