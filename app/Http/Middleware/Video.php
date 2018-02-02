<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class Video extends Middleware
{

    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
