<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/api/games',
        '/api/games/*',
        '/api/publishers',
        '/api/publishers/*',
        '/api/developers',
        '/api/developers/*',
        '/api/genres',
        '/api/genres/*',
        '/api/platforms',
        '/api/platforms/*',
        '/api/reviews',
        '/api/reviews/*'
    ];
}
