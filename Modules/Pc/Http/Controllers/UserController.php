<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\Ask;
use App\Admin\Model\Exam;
use App\Admin\Model\Exam_choose;
use App\Admin\Model\Judge;
use App\Admin\Model\Profession;
use App\Admin\Model\Study;
use App\User;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller{
    public function first(){
        $data['title']='个人中心';
        $data['user']=Auth::user();
        $data['studies']=DB::table('study_time')->select('s.*',DB::raw('sum(study_time) as study_time'))
            ->leftJoin('studies as s','study_time.sid','s.id')
            ->where('study_time.uid',$data['user']->id)
            ->groupBy('study_time.sid')
            ->get()->toArray();
        $data['study']=DB::table('study_time')->select('s.*','sid',DB::raw('sum(study_time) as study_time'))
            ->leftJoin('studies as s','study_time.sid','s.id')
            ->where('uid',$data['user']->id)->groupBy('sid')
            ->first();
        $sid=[];
        if(!$data['studies']) {
            return view('Pc.user.first')->with($data);
        }
        foreach ($data['studies'] as $k => $v) {
            if($v->video_num!=0) {
                $data['studies'][$k]->width = intval(($v->study_time / $v->video_num) * 100);
            }else{
                $data['studies'][$k]->width=0;
            }
            $sid[] = $v->id;
        }
        $data['studies_not_study']=DB::table('user_study')->select('s.*')
            ->leftJoin('studies as s','user_study.pid','s.pid')
            ->where('user_study.uid',$data['user']->id)
            ->whereNotIn('s.id',$sid)
            ->get()->toArray();
        if($data['studies_not_study']){
            foreach($data['studies_not_study'] as $k=>$v){
                $data['studies_not_study'][$k]->width=0;
                $data['studies_not_study'][$k]->study_time=0;
            }
        }
        if($data['study']->video_num!=0)
            $data['study']->width=intval(( $data['study']->study_time/ $data['study']->video_num)*100);
        else
            $data['study']->width=0;
        $data['studies']=array_merge($data['studies_not_study'],$data['studies']);
        $data['studies'] = array_values(array_sort_recursive($data['studies'], function ($value) {
            return $value->width;
        }));
        return view('Pc.user.first')->with($data);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        $data['title']='个人中心-个人资料';
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
        if(!preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/',$data['email'])){
            Session::flash('message_error', '请输入正确格式的邮箱账号', 3);
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
        if($request->file('pic')) {
            if($request->file('pic')->isValid()) {
                $data['pic'] = $request->file('pic')->store('images/' . $user->id, 'admin');
            }else{
                Session::flash('message_error', '头像文件太大，请选择小于2M的文件', 3);
                return redirect()->back();
            }
        }
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
    public function errorExam(Request $request,$type=0){

        $data['user']=Auth::user();
        if($type==2){
            $data['exam'] = DB::table('error_exams as error')
                ->select('p.name as pname', 'e.*', 'error.id as errorId', 'error.error', 'error.eChooseId as eid')
                ->leftJoin('exam_chooses as e', 'e.id', 'error.eChooseId')
                ->leftJoin('professions as p', 'p.id', 'e.pid')
                ->where('error.eid', 0);
        }else {
            $data['exam'] = DB::table('error_exams as error')
                ->select('p.name as pname', 'e.*', 'error.id as errorId', 'error.error', 'error.eid')
                ->leftJoin('exams as e', 'e.id', 'error.eid')
                ->leftJoin('professions as p', 'p.id', 'e.pid')
                ->where('error.eChooseId', 0);
        }
        if ($request->search) {
            $data['exam'] = $data['exam']->where('e.info', 'like', '%' . $request->search . "%");
        }
        $data['title']='错题库';
        $data['exam']=$data['exam']->where('error.uid',$data['user']->id)
            ->paginate(15);
        $data['type']=$type;
        return view('Pc.user.error_exam')->with($data);
    }
    //查询错题
    public function getExam(Request $request,$type=0){
        $id=$request->id;
        if($type==2){
            $data=Exam_choose::find($id);
            $true=[];
            foreach($data->true as $v){
                $true[]=$data->$v;
            }
            $data->true_array=$data->true;
            $data->true=$true;
        }else {
            $data = Exam::find($id);
        }
        if(!$data)
            return false;
        return $data;
    }
    //删除错题
    public function delExam(Request $request){
        $id=$request->id;
        $data = DB::table('error_exams')->find($id);
        if(!$data)
            return 'no';
        DB::table('error_exams')->whereId($id)->delete();
        return 'yes';
    }
    //在线学习
    public function online_study(Request $request){
        $data['title']='个人中心-在线学习';
        $data['user']=Auth::user();
        $pids=DB::table('user_study')->where('uid',$data['user']->id)->groupBy('pid')->pluck('pid')->toArray();
        $data['study_time']=DB::table('study_time')->select('sid',DB::raw('sum(study_time) as study_time'))->where('uid',$data['user']->id)->groupBy('sid')->get();
        $data['profession'] = Profession::whereIn('id', $pids)->get();
        if($data['profession']) {
            foreach ($data['profession'] as $k => $v) {
                $data['profession'][$k]['study']=Study::where('pid',$v->id)->get();
                $p_study=0;
                $all_video=0;
                foreach($data['profession'][$k]['study'] as $kk=>$vv){
                    foreach($data['study_time'] as $key=>$val){
                        if($val->sid==$vv->id){
                            if ($vv->video_num != 0) {
                                $data['profession'][$k]['study'][$kk]['width'] = intval(($val->study_time / $vv->video_num) * 100);
                            }else{
                                $data['profession'][$k]['study'][$kk]['width'] = 0;
                            }
                            $p_study+=$val->study_time;
                        }
                    }
                    $all_video+=$vv->video_num;
                }
                if($all_video!==0) {
                    $data['profession'][$k]['width'] = intval(($p_study / $all_video) * 100);
                }else{
                    $data['profession'][$k]['width']=0;
                }
            }
        }
        return view('Pc.user.online_study')->with($data);
    }
    //在线留言
    public function ask(Request $request){
        $data['title']='个人中心-在线留言';
        $data['user']=Auth::user();
        $data['ask']=Ask::where('uid',$data['user']->id);
        if($request->search){
            $data['ask']=$data['ask']->where('content','like','%'.$request->search.'%');
            $data['search']=$request->search;
        }
        $data['ask']=$data['ask']->paginate(15);
        return view('Pc.user.ask')->with($data);
    }
    //提交留言
    public function addAsk(Request $request){
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha'=>'验证码错误',
        ]);
        $error=0;
        if ($validator->fails()){
            $error=1;
        }
        if($error){
            return redirect(url('/user/ask'))
                ->withErrors($validator)
                ->withInput();
        }
        $data['content']=$request->get('content');
        $data['uid']=Auth::id();
        $data['status']=0;
        $data['sort']=0;
        $data['updated_at']=date('Y-m-d H:i:s',time());
        $data['created_at']=date('Y-m-d H:i:s',time());
        Ask::insert($data);
        unset($data);
        $data['title']='在线留言';
        $data['user']=Auth::user();
        $data['success']=1;
        $data['ask']=Ask::where('uid',$data['user']->id)->paginate(15);
        return view('Pc.user.ask')->with($data);
    }
    public function askDesc($id){
        $data=Ask::find($id);
        return \GuzzleHttp\json_encode($data);
    }
    public function online_exam(){
        $data['title']='个人中心-在线考试';
        $data['user']=Auth::user();
        $study_time=DB::table('study_time')
            ->select('pid',DB::raw('sum(study_time) as study_time'))
            ->where('uid',$data['user']->id)
            ->groupBy('pid')
            ->get();
        $profession_time=Study::select(DB::raw('sum(video_num) as sum'),'pid')->groupBy('pid')->get();
        $new_profession_time=[];
        foreach($profession_time as $k=>$v){
            $new_profession_time[$v->pid]=$v->sum;
        }
        $can_exam=[];
        foreach($study_time as $k=>$v){
            if($v->study_time>=$new_profession_time[$v->pid]){
                $can_exam[]=$v->pid;
            }
        }
        $data['pro']=Profession::whereIn('id',$can_exam)->get();
        //考试历史
        $data['history']=DB::table('examLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',$data['user']->id)
            ->get();
        return view('Pc.user.online_exam')->with($data);
    }
    public function exam($pid){
        $data['title']='个人中心-在线考试-考试中';
        $data['user']=Auth::user();
        $data['pro']=Profession::find($pid);
        try {
            $p_time = Study::select(DB::raw('sum(video_num) as sum'))->where('pid', $pid)->get();
            $s_time = DB::table('study_time')
                ->select(DB::raw('sum(study_time) as sum'))
                ->where('pid', $pid)
                ->where('uid', $data['user']->id)->get();
            if ($p_time[0]->sum == $s_time[0]->sum) {
                /*试题算法：
                    1,首先排除该用户已经回答过得题库
                    2,其次从题库中排除错题，视频中问题
                    3，如果排出后题目数量不足，则从错题库中加入
                    4，其次从视频中问题加入
                    5，最后从已经回答过得题库中加入(先加入错误的，再加入正确的)
                */
                $data['count']=0;
                if($data['pro']->exam_single) {
                    if(!$data['single'] = $this->getSingleExam($data, $pid)){
                        return $this->error(['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>url('/user/online_exam')]);
                    }
                    $data['count']+=$data['pro']->exam_single;
                }
                if($data['pro']->exam_choose) {
                    if(!$data['choose'] = $this->getChooseExam($data, $pid)){
                        return $this->error(['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>url('/user/online_exam')]);
                    }
                    $data['count']+=$data['pro']->exam_choose;
                }
                if($data['pro']->judge_num) {
                    if(!$data['judge'] = $this->getJudgeExam($data, $pid)){
                        return $this->error(['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>url('/user/online_exam')]);
                    }
                    $data['count']+=$data['pro']->judge_num;
                }
            }
            return view('Pc.user.exam')->with($data);
        }catch (Exception $e){
            return $this->error(['message'=>'非法操作！','type'=>'error']);
        }
    }
    //获取判断题
    private function getJudgeExam($data,$pid){
        $allExam=array_values(Judge::where('pid',$pid)->where('status',1)->pluck('id')->toArray());
        //1,首先排除该用户已经回答过得题库
        $examLog=DB::table('examLog')->where('uid',$data['user']->id)->where('pid',$pid)->get();
        $true_examLog=[];
        $error_examLog=[];
        if($examLog) {
            foreach ($examLog as $k=>$v){
                try{
                    $this->getExamLog($true_examLog,$error_examLog,config('exam.dir') . $v->file,2);
                }catch (Exception $e){

                }
            }
        }
        $exams=array_diff($allExam,array_merge($true_examLog,$error_examLog));
        //step 1 end
        //step 2 end
        if($data['exam']=$this->checkJudgeNum($exams,$data['pro']->judge_num)){
            return $data['exam'];
        }
        //step 3 end
        //5,最后从已经回答过得题库中加入(先加入错误的，再加入正确的)
        $exams=array_merge($exams,$error_examLog);
        if($data['exam']=$this->checkJudgeNum($exams,$data['pro']->judge_num)){
            return $data['exam'];
        }
        $exams=array_merge($exams,$true_examLog);
        if($data['exam']=$this->checkJudgeNum($exams,$data['pro']->judge_num)){
            return $data['exam'];
        }
        //step 5 end
        return [];
    }
    private function getExamLog(&$true_examLog,&$error_examLog,$file,$type){
        if (file_exists($file)) {
            $str = @file_get_contents($file);
            $data=json_decode($str,true);
            $examLog_arr=[];
            switch($type){
                case 0:
                    $examLog_arr=$data['id'];
                    break;
                case 1:
                    $examLog_arr=$data['duoxuan_id'];
                    break;
                case 2:
                    $examLog_arr=$data['panduan_id'];
                    break;
            }
            unset($data['id']);
            unset($data['duoxuan_id']);
            unset($data['panduan_id']);
            $afterChangeData=[];
            foreach($data as $v){
                $afterChangeData[$v['id']]=$v;
            }
            $true_examLog = array_merge($true_examLog, array_keys(array_where($afterChangeData, function ($value, $key)use($examLog_arr) {
                return $value['is_true']==true&&in_array($value['id'],$examLog_arr);
            })));
            $error_examLog = array_merge($error_examLog, array_keys(array_where($afterChangeData, function ($value, $key)use($examLog_arr) {
                return $value['is_true']==false&&in_array($value['id'],$examLog_arr);
            })));
        }
    }
    //获取单选题
    private function getSingleExam($data,$pid){
        //获取单选题
        $examInVideo=array_values(Exam::where('pid',$pid)->where('status',1)->where('vid','<>',0)->pluck('id')->toArray());
        $allExam=array_values(Exam::where('pid',$pid)->where('status',1)->pluck('id')->toArray());
        //1,首先排除该用户已经回答过得题库
        $examLog=DB::table('examLog')->where('uid',$data['user']->id)->where('pid',$pid)->get();
        $true_examLog=[];
        $error_examLog=[];
        if($examLog) {
            foreach ($examLog as $k=>$v){
                try{
                    $this->getExamLog($true_examLog,$error_examLog,config('exam.dir') . $v->file,0);
                }catch (Exception $e){

                }
            }
        }
        $exams=array_diff($allExam,array_merge($true_examLog,$error_examLog));
        //step 1 end
        // 2,其次从题库中排除错题
        $error_exam=array_values(DB::table('error_exams')->where('uid',$data['user']->id)->where('eid','<>',null)->pluck('eid')->toArray());
        $exams=array_diff($exams,$error_exam);
        //排除视频中问题
        $exams=array_diff($exams,$examInVideo);
        //step 2 end
        if($data['exam']=$this->checkSingleNum($exams,$data['pro']->exam_single)){
            return $data['exam'];
        }
        //3，如果排出后题目数量不足，则从错题库中加入
        $exams=array_merge($exams,$error_exam);
        if($data['exam']=$this->checkSingleNum($exams,$data['pro']->exam_single)){
            return $data['exam'];
        }
        //step 3 end
        //4,其次从视频中问题加入
        $exams=array_merge($exams,$examInVideo);
            if($data['exam']=$this->checkSingleNum($exams,$data['pro']->exam_single)){
            return $data['exam'];
        }
        //step 4 end
        //5,最后从已经回答过得题库中加入(先加入错误的，再加入正确的)
        $exams=array_merge($exams,$error_examLog);
        if($data['exam']=$this->checkSingleNum($exams,$data['pro']->exam_single)){
            return $data['exam'];
        }
        $exams=array_merge($exams,$true_examLog);
        if($data['exam']=$this->checkSingleNum($exams,$data['pro']->exam_single)){
            return $data['exam'];
        }
        //step 5 end
        return [];
    }
    //获取多选题
    private function getChooseExam($data,$pid){
        //获取多选题
        $allExam=array_values(Exam_choose::where('pid',$pid)->where('status',1)->pluck('id')->toArray());
        //1,首先排除该用户已经回答过得题库
        $examLog=DB::table('examLog')->where('uid',$data['user']->id)->where('pid',$pid)->get();
        $true_examLog=[];
        $error_examLog=[];
        if($examLog) {
            foreach ($examLog as $k=>$v){
                try{
                    $this->getExamLog($true_examLog,$error_examLog,config('exam.dir') . $v->file,1);
                }catch (Exception $e){

                }
            }
        }
        $exams=array_diff($allExam,array_merge($true_examLog,$error_examLog));
        //step 1 end
        // 2,其次从题库中排除错题
        $error_exam=array_values(DB::table('error_exams')->where('uid',$data['user']->id)->where('eChooseId','<>',null)->pluck('eid')->toArray());
        $exams=array_diff($exams,$error_exam);
        //step 2 end
        if($data['exam']=$this->checkChooseNum($exams,$data['pro']->exam_choose)){
            return $data['exam'];
        }
        //3，如果排出后题目数量不足，则从错题库中加入
        $exams=array_merge($exams,$error_exam);
        if($data['exam']=$this->checkChooseNum($exams,$data['pro']->exam_choose)){
            return $data['exam'];
        }
        //step 3 end
        //step 4 end
        //5,最后从已经回答过得题库中加入(先加入错误的，再加入正确的)
        $exams=array_merge($exams,$error_examLog);
        if($data['exam']=$this->checkChooseNum($exams,$data['pro']->exam_choose)){
            return $data['exam'];
        }
        $exams=array_merge($exams,$true_examLog);
        if($data['exam']=$this->checkChooseNum($exams,$data['pro']->exam_choose)){
            return $data['exam'];
        }
        //step 5 end
        return [];
    }
    //检查单选题数量
    private function checkSingleNum($exams,$num){
        $exams=array_unique($exams);
        if(count($exams)>=$num){
            $res=Exam::whereIn('id',array_slice($exams,0,$num))->where('status',1)->get()->toArray();
            if(count($res)<$num){
                return false;
            }
            shuffle($res);
            shuffle($res);
            foreach($res as $k=>$v){
                $choose=[$v['choose_1'],$v['choose_2'],$v['choose_3'],$v['choose_4']];
                shuffle($choose);
                shuffle($choose);
                $res[$k]['choose']=$choose;
            }
            return $res;
        }else{
            return false;
        }
    }
    //检查多选题数量
    private function checkChooseNum($exams,$num){
        $exams=array_unique($exams);
        if(count($exams)>=$num){
            $res=Exam_choose::whereIn('id',array_slice($exams,0,$num))->where('status',1)->get()->toArray();
            if(count($res)<$num){
                return false;
            }
            shuffle($res);
            shuffle($res);
            foreach($res as $k=>$v){
                $choose=[$v['choose_1'],$v['choose_2'],$v['choose_3'],$v['choose_4']];
                if($v['choose_5'])
                    $choose[]=$v['choose_5'];
                if($v['choose_6'])
                    $choose[]=$v['choose_6'];
                if($v['choose_7'])
                    $choose[]=$v['choose_7'];
                shuffle($choose);
                shuffle($choose);
                $res[$k]['choose']=$choose;
            }
            return $res;
        }else{
            return false;
        }
    }
    //检查判断题数量
    private function checkJudgeNum($exams,$num){
        $exams=array_unique($exams);
        if(count($exams)>=$num){
            $res=Judge::whereIn('id',array_slice($exams,0,$num))->where('status',1)->get()->toArray();
            if(count($res)<$num){
                return false;
            }
            shuffle($res);
            shuffle($res);
            return $res;
        }else{
            return false;
        }
    }
    //提交考试
    private function submit($request,$type){
        $examLog['uid']=$request->get('uid');
        if(strpos(url()->previous(),"/user/{$type}/")===false||$request->method()!='POST'||$examLog['uid']!=Auth::user()->id){
            return $this->error(['message'=>'非法操作！','type'=>'error']);
        }
        $data=$request->except('_token','time','pid','uid','count','id','duoxuan_id','panduan_id');
        $res['time']=$request->get('time');
        $examLog['pid']=$request->get('pid');
        $pro=Profession::find($examLog['pid']);
        $res['value'] = 0;
        $choose=[];
        $single=[];
        $judge=[];
        $now=date('Y-m-d H:i:s');
        if($data) {
            foreach($data as $k=>$v){
                if(strpos($k,'duoxuan')!==false){
                    $choose[substr($k,8)]=$v;
                }else if(strpos($k,'panduan')!==false){
                    $judge[substr($k,8)]=$v;
                }else{
                    $single[$k]=$v;
                }
            }
            $single_data = Exam::whereIn('id', array_keys($single))->get();
            $choose_data=Exam_choose::whereIn('id', array_keys($choose))->get();
            $judge_data=Judge::whereIn('id', array_keys($judge))->get();
            $file['id'] = $request->get('id');
            $file['duoxuan_id'] = $request->get('duoxuan_id');
            $file['panduan_id'] = $request->get('panduan_id');
            //单选处理
            foreach ($single_data as $k => $v) {
                if ($v->true === $single[$v->id]) {
                    $res['value'] += $pro->single_value;
                    $file[] = ['id'=>$v->id,'res'=>$single[$v->id],'is_true'=>true,'type'=>1];
                } else {
                    $file[] = ['id'=>$v->id,'res'=>$single[$v->id],'is_true'=>false,'type'=>1];
                }
            }
            //多选处理
            foreach ($choose_data as $k => $v) {
                $is_true=1;
                foreach($v->true as $key=>$val){
                    if(in_array($v->$val,$choose[$v->id])){
                        continue;
                    }else{
                        $is_true=0;
                    }
                }
                if ($is_true === 1 && count($v->true)==count($choose[$v->id])) {
                    $res['value'] += $pro->choose_value;
                    $file[] = ['id'=>$v->id,'res'=>json_encode($choose[$v->id]),'is_true'=>true,'type'=>2];
                } else {
                    $file[] = ['id'=>$v->id,'res'=>json_encode($choose[$v->id]),'is_true'=>false,'type'=>2];
                }
            }
            //判断题处理
            foreach ($judge_data as $k => $v) {
                if ($v->is_true == $judge[$v->id]) {
                    $res['value'] += $pro->judge_value;
                    $file[] = ['id'=>$v->id,'res'=>$judge[$v->id],'is_true'=>true,'type'=>3];
                } else {
                    $file[] = ['id'=>$v->id,'res'=>$judge[$v->id],'is_true'=>false,'type'=>3];
                }
            }
            $examLogStr = json_encode($file);
            $examLog['use_time']=$res['time'];
            $examLog['value']=$res['value'];
            $examLog['time']=$now;
            $examLog['file']=$examLog['uid'].'/'.$examLog['uid'].time().rand(1,9999).'.txt';
            $dir=config("exam.".($type=='exam'?'dir':$type));
            if(!is_dir($dir.$examLog['uid'])){
                mkdir($dir.$examLog['uid']);
            }
            file_put_contents($dir.$examLog['file'],$examLogStr);
            $res['id']=DB::table("{$type}Log")->insertGetId($examLog);
            $res['error']=0;
        }else{
            //未作答任何题目
            $res['error']=1;
        }
        return json_encode($res);
    }
    public function submitExam(Request $request){
       return $this->submit($request,'exam');
    }

    public function seeExam($eid){
        return $this->seeFile($eid,1);
    }
    private function seeFile($eid,$type){
        $table=$type?'examLog':'testLog';
        $view=$type?'seeExam':'seeTest';
        $type=$type?'exam':'test';
        $exam=DB::table($table)->find($eid);
        $data['pro']=Profession::find($exam->pid);
        $data['user']=Auth::user();
        if(!$exam){
            return $this->error(['message'=>'非法操作！','type'=>'error']);
        }
        $exam_str=file_get_contents(config('exam.'.($type=='exam'?'dir':$type)).$exam->file);
        $exam_arr=json_decode($exam_str,true);
        $single_id=$exam_arr['id']?:[];
        $choose_id=$exam_arr['duoxuan_id']?:[];
        $judge_id=$exam_arr['panduan_id']?:[];
        unset($exam_arr['id']);
        unset($exam_arr['duoxuan_id']);
        unset($exam_arr['panduan_id']);
        $single=Exam::whereIn('id',$single_id)->get()->toArray();
        $choose=Exam_choose::whereIn('id',$choose_id)->get()->toArray();
        $judge=Judge::whereIn('id',$judge_id)->get()->toArray();
        $yida_single=[];
        $yida_choose=[];
        $yida_judge=[];
        //单选
        foreach($single as $k=>$v){
            $data['single'][$v['id']] = $v;
            foreach($exam_arr as $kk=>$vv) {
                if ($v['id'] == $vv['id']&&$vv['type']==1) {
                    $data['single'][$v['id']] = array_merge($v, $vv);
                    $yida_single[] = $v['id'];
                }
            }
        }
        //多选
        foreach($choose as $k=>$v){
            $true=[];
            foreach($v['true'] as $val){
                $true[]=$v[$val];
            }
            $v['true']=implode(',',$true);
            $data['choose'][$v['id']] = $v;
            foreach($exam_arr as $kk=>$vv) {
                if ($v['id'] == $vv['id']&&$vv['type']==2){
                    $vv['res'] = implode(',', json_decode($vv['res'], true));
                    $data['choose'][$v['id']] = array_merge($v, $vv);
                    $yida_choose[] = $v['id'];
                }
            }
        }
        //判断
        foreach($judge as $k=>$v){
            $data['judge'][$v['id']] = $v;
            foreach($exam_arr as $kk=>$vv) {
                if ($v['id'] == $vv['id']&&$vv['type']==3) {
                    $data['judge'][$v['id']] = array_merge($v, $vv);
                    $yida_judge[] = $v['id'];
                }
            }
        }
        $data['weida_single']=array_diff($single_id,$yida_single);
        $data['weida_choose']=array_diff($choose_id,$yida_choose);
        $data['weida_judge']=array_diff($judge_id,$yida_judge);
        $data['examLog']=$exam;
        $data['zuodalv']=intval(count($exam_arr)/(count($single)+count($choose)+count($judge))*100);
        return view('Pc.user.'.$view)->with($data);
    }
    //在线练习
    public function online_test(){
        $data['title']='个人中心-在线练习';
        $data['user']=Auth::user();
        $study_time=DB::table('study_time')
            ->select('pid',DB::raw('sum(study_time) as study_time'))
            ->where('uid',$data['user']->id)
            ->groupBy('pid')
            ->get();
        $profession_time=Study::select(DB::raw('sum(video_num) as sum'),'pid')->groupBy('pid')->get();
        $new_profession_time=[];
        foreach($profession_time as $k=>$v){
            $new_profession_time[$v->pid]=$v->sum;
        }
        $can_exam=[];
        foreach($study_time as $k=>$v){
            $can_exam[]=$v->pid;
        }
        $data['pro']=Profession::whereIn('id',$can_exam)->get();
        //考试历史
        $data['history']=DB::table('testLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',$data['user']->id)
            ->get();
        return view('Pc.user.online_test')->with($data);
    }
    public function test($pid){
        $data['title']='个人中心-在线练习-练习中';
        $data['user']=Auth::user();
        $data['pro']=Profession::find($pid);
        try {
                /*试题算法：
                    1,首先排除该用户已经回答过得题库
                    2,其次从题库中排除错题，视频中问题
                    3，如果排出后题目数量不足，则从错题库中加入
                    4，其次从视频中问题加入
                    5，最后从已经回答过得题库中加入(先加入错误的，再加入正确的)
                */
            $data['count']=0;
            if($data['pro']->exam_single) {
                if(!$data['single'] = $this->getSingleTest($data, $pid)){
                    return $this->error(['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>url('/user/online_test')]);
                }
                $data['count']+=$data['pro']->exam_single;
            }
            if($data['pro']->exam_choose) {
                if(!$data['choose'] = $this->getChooseTest($data, $pid)){
                    return $this->error(['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>url('/user/online_test')]);
                }
                $data['count']+=$data['pro']->exam_choose;
            }
            if($data['pro']->judge_num) {
                if(!$data['judge'] = $this->getJudgeTest($data, $pid)){
                    return $this->error(['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>url('/user/online_test')]);
                }
                $data['count']+=$data['pro']->judge_num;
            }
            return view('Pc.user.test')->with($data);
        }catch (Exception $e){
            return $this->error(['message'=>'非法操作！','type'=>'error']);
        }
    }
    //获取判断题
    private function getJudgeTest($data,$pid){
        $allExam=array_values(Judge::where('pid',$pid)->where('status',1)->pluck('id')->toArray());
        if($data['exam']=$this->checkJudgeNum($allExam,$data['pro']->judge_num)){
            return $data['exam'];
        }else {
            return [];
        }
    }
    //获取单选题
    private function getSingleTest($data,$pid){
        //获取单选题
        $allExam=array_values(Exam::where('pid',$pid)->where('status',1)->pluck('id')->toArray());
        if($data['exam']=$this->checkSingleNum($allExam,$data['pro']->exam_single)){
            return $data['exam'];
        }
        //step 5 end
        return [];
    }
    //获取多选题
    private function getChooseTest($data,$pid){
        //获取多选题
        $allExam=array_values(Exam_choose::where('pid',$pid)->where('status',1)->pluck('id')->toArray());
        if($data['exam']=$this->checkChooseNum($allExam,$data['pro']->exam_choose)){
            return $data['exam'];
        }
        return [];
    }
    //提交练习试卷
    public function submitTest(Request $request){
       return $this->submit($request,'test');
    }
    public function seeTest($eid){
        return $this->seeFile($eid,0);
    }
    public function error($message=['type'=>'error','msg'=>'操作失败']){
        $data['user']=Auth::user();
        $data['title']='跳转中...';
        $data['message']=$message;
        $data['url']=$message['url']??url('/user');
        return view('Pc.user.error')->with($data);
    }
    //教育档案
    public function archive($search=''){
        $data['user']=Auth::user();
        $data['title']='个人中心-教育档案';
        $data['pro']=Profession::select('professions.name as pname','e.value','e.time')
            ->leftJoin('examLog as e','e.pid','professions.id')
            ->where('e.uid',$data['user']->id)
            ->where('e.value','>=',60);
        if($search){
            $data['pro']=$data['pro']->where('professions.name','like','%'.$search."%");
        }
        $data['pro']=$data['pro']  ->groupBy('professions.id')
            ->paginate (15);
        $data['search']=$search;
        return view('Pc.user.archive')->with($data);
    }
    //考核情况
    public function res(){
        $data['user']=Auth::user();
        $data['title']='个人中心-考核情况';
        $data['pro']=Profession::select('professions.name as pname','e.value','e.time')
            ->leftJoin('examLog as e','e.pid','professions.id')
            ->where('e.uid',$data['user']->id)
            ->groupBy('professions.id')
            ->orderBy('e.value','desc')
            ->get();
        return view('Pc.user.res')->with($data);
    }
    //资料下载
    public function file(){
        $data['user']=Auth::user();
        $data['title']='个人中心-资料下载';
        $data['file']=\App\Admin\Model\File::where('is_admin', 1)
            ->orWhere(function ($query) use($data){
                $query->where('is_admin', 0)
                    ->where('uid', '=', $data['user']->id);
            })->paginate(15);
        return view('Pc.user.file')->with($data);
    }
    public function downloadFile($filename){
        $file=\App\Admin\Model\File::where('is_admin', 1)
            ->orWhere(function ($query){
                $query->where('is_admin', 0)
                    ->where('uid', '=', Auth::user()->id);
            })->get();
        if($file) {
            foreach ($file as $k=>$v){
                if(strpos($v->path,$filename)!==false){
                    return response()->download('../storage/uploads/files/'.$filename);
                }
            }
        }
        return $this->error();
    }
}
