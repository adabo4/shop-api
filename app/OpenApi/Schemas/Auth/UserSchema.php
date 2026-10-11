<?php

namespace App\OpenApi\Schemas\Auth;


use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    title: 'User',
    description: 'Customer account information.',
    required: [
        'id',
        'first_name',
        'last_name',
        'email',
    ],
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 1
        ),
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
            property: 'email_verified_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: null
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: '2026-10-11T15:10:13.000000Z'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: '2026-10-11T15:10:13.000000Z'
        ),
    ],
    type: 'object'
)]
class UserSchema {}
