<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Vitalis Shop API',
    description: 'REST API for Vitalis Shop'
)]
#[OA\Server(
    url: 'http://localhost:8000',
    description: 'Local development server'
)]
class Documentation {}
