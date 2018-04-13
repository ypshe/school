<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        return view('Mobile.user.register');
    }
    public function add(Request $request){
        $validator = Validator::make(Input::all(), [
            'captcha' => 'required|captcha',
            'cardId' => 'regex:/^\d{17}[0-9xX]{1}$/|alpha_num|required|unique:users,cardID',
            'password' => 'required|string|min:6|max:18|confirmed'
        ], [
            'regex'=>'请输入正确格式的身份证号',
            'alpha_num'=>'请输入正确格式的身份证号',
            'unique'=>'身份证号已存在，请核实后再输入',
            'captcha'=>'验证码错误',
        ]);
        $error=0;
        if ($validator->fails()){
            $error=1;
        }
        if($error){
            if(strstr(url()->previous(),'/wap/register')){
                $this->redirectTo='/wap/register';
            }
            return redirect('/wap/register')
                ->withErrors($validator)
                ->withInput();
        }else{
            $id=$this->create($request->all());
            Auth::loginUsingId($id);
            return response()
                ->view('Mobile.error', ['msg'=>'注册成功！','type'=>'success','url'=>'/wap/user']);
        }
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    private function create(array $data)
    {
        return User::insertGetId([
            'cardId' => $data['cardId'],
            'password' => bcrypt($data['password'])
        ]);
    }
}
