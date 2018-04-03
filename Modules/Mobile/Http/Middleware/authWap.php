<?php

namespace Modules\Mobile\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Facades\Agent;
use App\Admin\Model\User;

class authWap extends Middleware
{

    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            if (strpos(Agent::getUserAgent(), 'MicroMessenger') !== false){
                $user=session('wechat.oauth_user.default');
                if(!$user){
                    $app = app('wechat.official_account');
                    $response = $app->oauth->scopes(['default'])
                        ->redirect();
                    $_SESSION['wechat_user']=$app->oauth->user();
                    return $response;
                }else{
                    $userData=User::where('wx_openId',$user->id)->first();
                    if(!$userData){
                        return response()
                            ->view('Mobile.error', ['msg' => '请先验证身份证号与登录密码，与电脑端账号绑定！如果没有电脑端账号请注册！', 'type' => 'error', 'url' => '/wap/login/wx'], 200);
                    }else{
                        if($userData->wx_openId!==$user->id){
                            return response()
                                ->view('Mobile.error', ['msg' => '系统检测到该账号存在绑定的微信号，如需更换绑定请先到原微信号解除绑定！', 'type' => 'error', 'url' => '/wap/login/wx'], 200);
                        }
                        Auth::loginUsingId($userData->id);
                    }
                }
            }else {
                    return response()
                        ->view('Mobile.error', ['msg' => '请先登录！', 'type' => 'error', 'url' => '/wap/login'], 200);
            }
        }
        return $next($request);
    }
}
