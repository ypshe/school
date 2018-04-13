<?php

namespace App\Http\Controllers\Auth;

use App\Admin\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.findPwd')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        if(!User::where('cardId',$request->cardId)->where('email',$request->email)->first()){
            return redirect($this->redirectTo)
                ->withErrors(['email'=>'邮箱与身份证号不匹配！'])
                ->withInput();
        }
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'cardId' => 'regex:/^\d{17}[0-9xX]{1}$/|alpha_num|required|exists:users,cardId',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6|max:18',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'cardId.regex'=>'请输入正确格式的身份证号',
            'cardId.alpha_num'=>'请输入正确格式的身份证号',
            'cardId.exists'=>'身份证号不存在',
            'password.required'=>'请输入密码',
            'password.confirmed'=>'两次输入密码不同',
            'password.min'=>'密码最小长度为6',
            'password.max'=>'密码最大长度为18',
            'email.email'=>'请输入正确格式的邮箱号',
            'email.required'=>'请输入邮箱号',
            'email.exists'=>'邮箱有误，或您未补充邮箱信息！',
            ];
    }
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }
    protected function sendResetResponse($response)
    {
        return view('auth.passwords.success');
    }
}
