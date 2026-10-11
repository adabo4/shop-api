<?php

namespace App\OpenApi\Paths;

use OpenApi\Attributes as OA;


#[OA\Post(
    path: '/api/auth/register',
    summary: 'Register a new customer',
    description: 'Create a new customer account and start an authenticated session.',
    tags: ['Auth'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: '#/components/schemas/RegisterRequest'
        )
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: 'User registered successfully'
        ),
        new OA\Response(
            response: 422,
            description: 'Validation error'
        ),
    ]
)]


#[OA\Post(
    path: '/api/auth/login',
    summary: 'Log in a customer',
    description: 'Authenticate an existing customer using email and password.',
    tags: ['Auth'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: '#/components/schemas/LoginRequest'
        )
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'User logged in successfully'
        ),
        new OA\Response(
            response: 401,
            description: 'Invalid email or password'
        ),
        new OA\Response(
            response: 422,
            description: 'Validation error'
        ),
    ]
)]

class AuthPaths {}
