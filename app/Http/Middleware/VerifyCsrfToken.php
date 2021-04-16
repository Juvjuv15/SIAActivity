<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    // protected $except = [
    //     'http://127.0.0.1:8000/map',
    //     'http://127.0.0.1:8000/*',
    //     // 'http://localhost',
    //     // 'http://localhost:8000/map',
    // ];
    protected $except = [
        'http://127.0.0.1:8000/map',
        'http://127.0.0.1:8000/*',
        'http://localhost:8000/map',
        'http://localhost:8000/*',
        'http://localhost:8000/filter',
        'http://localhost:8000/searchLots',
        //
    ];
}
