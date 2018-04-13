<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'captcha' => 'required|captcha',
            'cardId' => 'regex:/^\d{17}[0-9xX]{1}$/|alpha_num|required|unique:users,cardID',
            'password' => 'required|string|min:6|max:18|confirmed'
            ], [
                'regex'=>'请输入正确格式的身份证号',
                'alpha_num'=>'请输入正确格式的身份证号',
                'unique'=>'身份证号已存在，请核实后再输入',
                'captcha'=>'验证码错误',
                'password.required'=>'请输入密码',
                'password.confirmed'=>'两次输入密码不同',
                'password.min'=>'密码最小长度为6',
                'password.max'=>'密码最大长度为18',
            ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'cardId' => $data['cardId'],
            'password' => bcrypt($data['password'])
        ]);
    }
}
