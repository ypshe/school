<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\Exam;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $need=[
	    'name','where_p','where_c','home_p','home_c','home_a','cardId','sex','political','pic','nationality','phone','home'
        //	password
        //	remember_token:用户token,
        //	create_at:创建时间,
        //	updated_at:修改时间,
        //	where:籍贯,（省市下拉框）
        //	cardId:身份证号,（校验18位整数）
        //	home:家庭住址,（省市区下拉框，详情增加文本框）
        //	pic:头像,（文件框，能显示图片最好）
        //	sex:性别,（radio）
        //	political:政治面貌(党员，群众),（radio）
        //	nationality:民族,（文本框）
        //	phone:手机号,（文本框）（校验手机号）
        //	openId:微信openId
    ];
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        $data['title']='个人中心';
        $data['user']=Auth::user();
        $data['p']=DB::table('addr')->where('type',3)->get();
        return view('Pc.user.index')->with($data);
    }

    //修改用户信息
    public function edit(Request $request){
        $data=$request->except('_token');
        $user=User::where('cardId',$data['cardIdOld'])->first();
        Session::flash('userIndexType', 0);
        if(!Hash::check($data['password'], $user->password)){
            Session::flash('message_error', '密码错误', 3);
            return redirect()->back()->withInput();
        }
        if(!$request->file('pic')&&!$user->pic){
            Session::flash('message_error', '请选择头像', 3);
            return redirect()->back()->withInput();
        }
        if(!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',$data['name'])){
            Session::flash('message_error', '请输入正确格式的姓名', 3);
            return redirect()->back()->withInput();
        }
        if(!in_array($data['sex'],['男','女'])){
            Session::flash('message_error', '请选择性别', 3);
            return redirect()->back()->withInput();
        }
        if(!in_array($data['political'],['群众','党员'])){

            Session::flash('message_error', '请选择政治面貌', 3);
            return redirect()->back()->withInput();
        }
        if(!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){1,9}$/',$data['nationality'])){
            Session::flash('message_error', '请输入正确格式的民族', 3);
            return redirect()->back()->withInput();
        }
        if(!preg_match('/^\d{17}[0-9xX]{1}$/',$data['cardId'])){

            Session::flash('message_error', '请输入正确格式的身份证号', 3);
            return redirect()->back()->withInput();
        }
        if(!$data['where_p']||!$data['where_c']){
            Session::flash('message_error', '请选择籍贯', 3);
            return redirect()->back()->withInput();
        }
        if(!$data['home_p']||!$data['home_c']||!$data['home_a']||!$data['home']){
            Session::flash('message_error', '请输入住址', 3);
            return redirect()->back()->withInput();
        }
        if($data['cardId']!=$data['cardIdOld']){
            $res=User::where('cardId',$data['cardId']);
            if($res){
                Session::flash('message_error', '身份证号已在该系统注册，请核对后输入', 3);
                return redirect()->back()->withInput();
            }
        }
        if($request->file('pic'))
            $data['pic']=$request->file('pic')->store('images/'.$user->id,'admin');
        unset($data['cardIdOld']);
        $data['password']=bcrypt($data['password']);
        $data['status']=1;
        $res=DB::table('users')->whereId($user->id)->update($data);
        if($res){
            Session::flash('message_error', '修改成功', 3);
            return redirect()->back();
        }else{
            Session::flash('message_error', '修改失败', 3);
            return redirect()->back()->withInput();
        }
    }
    //修改密码
    public function updatePwd(Request $request){
        $data=$request->except('_token');
        Session::flash('userIndexType', 1);
        if(!$data['pwd']){
            Session::flash('message_error', '请输入密码', 3);
            return redirect()->back()->withInput();
        }
        if(!$data['password1']){
            Session::flash('message_error', '请输入新密码', 3);
            return redirect()->back()->withInput();
        }
        if(!$data['password2']){
            Session::flash('message_error', '请输入确认密码', 3);
            return redirect()->back()->withInput();
        }
        if(!preg_match('/^[a-zA-Z0-9]{6,18}$/',$data['password1'])){
            Session::flash('message_error', '新密码格式必须为6到18位字符', 3);
            return redirect()->back()->withInput();
        }
        if($data['password2']!==$data['password1']){
            Session::flash('message_error', '两次输入密码不同', 3);
            return redirect()->back()->withInput();
        }
        if(!Hash::check($data['pwd'], Auth::user()->password)){
            Session::flash('message_error', '密码错误', 3);
            return redirect()->back()->withInput();
        }
        $res=DB::table('users')->whereId(Auth::user()->id)->update(['password'=>bcrypt($data['password1'])]);
        if($res){
            Session::flash('message_error', '修改密码成功，请下次使用新密码登录', 3);
            return redirect()->back()->withInput();
        }
    }
    public function errorExam(Request $request){
        $data['user']=Auth::user();
        $data['exam']=Exam::select('exams.*','studies.name as sname','error_exams.*','error_exams.id as errorId')
            ->leftjoin('error_exams','exams.id','error_exams.eid')
            ->leftjoin('studies','studies.id','exams.sid');
        if($request->search){
            $data['exam']=$data['exam']->where('exams.info','like','%'.$request->search."%");
        }
        $data['title']='错题库';
        $data['exam']=$data['exam']->where('error_exams.uid',$data['user']->id)
            ->paginate(15);
        return view('Pc.user.error_exam')->with($data);
    }
    //查询错题
    public function getExam(Request $request){
        $id=$request->id;
        $data=Exam::find($id);
        if(!$data)
            return false;
        return $data;
    }
    //删除错题
    public function delExam(Request $request){
        $id=$request->id;
        $data=DB::table('error_exams')->find($id);
        if(!$data)
            return 'no';
        DB::table('error_exams')->whereId($id)->delete();
        return 'yes';
    }
}
