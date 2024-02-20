<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/login',
        '/logout',
        '/api/category',
        '/api/category/*',
        '/api/item',
        '/api/item/*',
        '/api/warehouse',
        '/api/warehouse/*',
        '/api/product',
        '/api/product/*',
        '/api/product/warehouse/*',
        '/api/client',
        '/api/client/*',
        '/api/pricing',
        '/api/pricing/*',
        '/api/product/create',
        '/api/client/create',
        '/api/purchase',
        '/api/purchase/create'
    ];
}
