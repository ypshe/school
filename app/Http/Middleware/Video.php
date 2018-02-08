<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Support\Facades\Auth;

class Video extends Middleware
{

    public function handle($request, Closure $next)
    {
        if(Auth::check()&&Auth::user()->status!==1){
            return redirect('/user');
        }
        return $next($request);
    }
}
