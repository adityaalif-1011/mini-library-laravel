<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        '/kantin/*',
        '/kantin/order',
        '/kantin/payment/*',
        '/kantin/snap-token/*',
        '/order',
        '/payment/*',
        '/snap-token/*',
    ];
}