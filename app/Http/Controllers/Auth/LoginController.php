<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'cardId';
    }
    protected function attemptLogin(Request $request)
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
            if(strstr(url()->previous(),'/login')){
                $this->redirectTo='/login';
            }
            return redirect($this->redirectTo)
                ->withErrors($validator)
                ->withInput();
        }
    }
}
