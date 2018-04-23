<?php

namespace Modules\Mobile\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Support\Facades\Auth;

class authMobile extends Middleware
{

    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return response()
                ->view('Mobile.error', ['msg' => '请先登录！', 'type' => 'error', 'url' => '/wap/login'], 200);
        }
        return $next($request);
    }
}
