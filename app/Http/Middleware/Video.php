<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Facades\Agent;
use Modules\Pc\Http\Controllers\UserController;

class Video extends Middleware
{

    public function handle($request, Closure $next)
    {
        if(Auth::check()&&Auth::user()->status!==1){
            if(Agent::isMobile()){
                return response()
                    ->view('Mobile.error',
                        ['msg'=>'请先完善个人信息再参与学习！','type'=>'error','url'=>url('/wap/user/index')],
                        200);
            }else{
                return response()
                        ->view('Pc.user.error',
                            ['user'=>Auth::user(),'title'=>'错误','message'=>['msg'=>'请先完善个人信息再参与学习！','type'=>'error','url'=>url('/user/index')]],
                            200);
            }
        }
        return $next($request);
    }
}
