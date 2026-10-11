<?php

namespace App\OpenApi\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'RegisterRequest',
    title: 'Register Request',
    description: 'Data required to register a new customer.',
    required: [
        'first_name',
        'last_name',
        'email',
        'password',
        'password_confirmation',
    ],
    properties: [
        new OA\Property(
            property: 'first_name',
            type: 'string',
            example: 'Test'
        ),
        new OA\Property(
            property: 'last_name',
            type: 'string',
            example: 'Vitalis'
        ),
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            example: 'test@example.sk'
        ),
        new OA\Property(
            property: 'phone',
            type: 'string',
            nullable: true,
            example: '0901234567'
        ),
        new OA\Property(
            property: 'password',
            type: 'string',
            format: 'password',
            writeOnly: true,
            example: 'MojeHeslo123'
        ),
        new OA\Property(
            property: 'password_confirmation',
            type: 'string',
            format: 'password',
            writeOnly: true,
            example: 'MojeHeslo123'
        ),
    ],
    type: 'object'
)]
class RegisterRequestSchema {}
