<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Jenssegers\Agent\Facades\Agent;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    private $redirectTo='/wap/login';
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        return view('Mobile.user.login');
    }
    public function attemptLogin(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'captcha' => 'required|captcha',
            'cardId' => 'regex:/^\d{17}[0-9xX]{1}$/|alpha_num|required|exists:users,cardId',
            'password' => 'required|string|min:6|max:18'
        ], [
            'cardId.regex'=>'请输入正确格式的身份证号',
            'cardId.alpha_num'=>'请输入正确格式的身份证号',
            'captcha.captcha'=>'验证码错误',
            'cardId.exists'=>'身份证号不存在',
        ]);
        $error=0;
        if ($validator->fails()){
            $error=1;
        }else{
            if (!Auth::attempt(['cardId' => $request->cardId, 'password' => $request->password],$request->remember)) {
                $validator->errors()->add('password', '密码错误');
                $error=1;
            }
        }
        if($error){
            if(strstr(url()->previous(),'/wap/login')){
                $this->redirectTo='/wap/login';
            }
            return redirect($this->redirectTo)
                ->withErrors($validator)
                ->withInput();
        }else{
            if (strpos(Agent::getUserAgent(), 'MicroMessenger') !== false) {
                $user = session('wechat.oauth_user.default');
                $data['wx_openId']=$user->id;
                $data['wx_name']=$user->nickname;
                $data['wx_pic']=$user->avatar;
                User::where('id',Auth::user()->id)->update($data);
            }
            return response()
                ->view('Mobile.error', ['msg'=>'登录成功！','type'=>'success','url'=>'/wap/user']);
        }
    }
    public function logout(){
        Auth::logout();
        return response()
            ->view('Mobile.error', ['msg'=>'退出成功！','type'=>'success','url'=>'/wap']);
    }
    //微信登录
    public function wx(){
        return view('Mobile.user.login')->with(['wx'=>1]);
    }
}
