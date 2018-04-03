<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\Ask;
use App\Admin\Model\Exam;
use App\Admin\Model\Exam_choose;
use App\Admin\Model\ExamLog;
use App\Admin\Model\Judge;
use App\Admin\Model\Notice;
use App\Admin\Model\Profession;
use App\Admin\Model\Study;
use App\Admin\Model\User;
use App\Admin\Model\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Facades\Agent;

class UserController extends Controller
{
    private $num=8;
    //用户信息完善度校验
    private static $info=[
        'cardId','sex','phone','email','political','nationality'
    ];
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        $data['user']=Auth::user();
        return view('Mobile.user.index')->with($data);
    }
    //个人设置
    public function set(){
        if (strpos(Agent::getUserAgent(), 'MicroMessenger') !== false) {
            return view('Mobile.user.set')->with(['wx'=>1]);
        }
        return view('Mobile.user.set');
    }
    //个人资料
    public function first(){
        $data['user']=Auth::user();
        return view('Mobile.user.first')->with($data);
    }
    //我要留言
    public function ask(){
        $data['user']=Auth::user();
        $data['ask']=Ask::where('uid',$data['user']->id)->get();
        return view('Mobile.user.ask')->with($data);
    }
    //提交留言
    public function ajaxAddAsk(Request $request){
        $data['content']=$request->get('content');
        $data['uid']=Auth::user()->id;
        $data['created_at']=date('Y-m-d H:i:s',time());
        $data['status']=0;
        $data['sort']=0;
        $data['updated_at']=date('Y-m-d H:i:s',time());
        return json_encode(['msg'=>Ask::insert($data)]);
    }
    //修改密码
    public function changePwd(){
        return view('Mobile.user.changePwd');
    }
    public function submitPwd(Request $request){
        $data=$request->except('_token');
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
            return response()
                ->view('Mobile.error', ['msg'=>'修改成功！','type'=>'success','url'=>'/wap/user/set'], 200);
        }
    }
    //资料库
    public function file(){
        return view('Mobile.user.file');
    }
    //在线学习
    public function online_study(){
        $data['user'] = Auth::user();
        $pids = DB::table('user_study')->where('uid', $data['user']->id)->groupBy('pid')->pluck('pid')->toArray();
        $data['study_time'] = DB::table('study_time')->select('sid', DB::raw('sum(study_time) as study_time'))->where('uid', $data['user']->id)->groupBy('sid')->get();
        $data['profession'] = Profession::whereIn('id', $pids)->get();
        if ($data['profession']) {
            foreach ($data['profession'] as $k => $v) {
                $data['profession'][$k]['study'] = Study::where('pid', $v->id)->get();
                $p_study = 0;
                $all_video = 0;
                foreach ($data['profession'][$k]['study'] as $kk => $vv) {
                    foreach ($data['study_time'] as $key => $val) {
                        if ($val->sid == $vv->id) {
                            if ($vv->video_num != 0) {
                                $data['profession'][$k]['study'][$kk]['width'] = intval(($val->study_time / $vv->video_num) * 100);
                            }else{
                                $data['profession'][$k]['study'][$kk]['width'] = 0;
                            }
                            $p_study += $val->study_time;
                        }
                        $all_video += $vv->video_num;
                    }
                }
            }
        }
        return view('Mobile.user.online_study')->with($data);
    }
    //在线练习
    public function online_test(){
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
        return view('Mobile.user.online_test')->with($data);
    }
    //练习历史
    public function test_history(){
        $data['history']=DB::table('testLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',Auth::user()->id)
            ->limit($this->num)
            ->get();
        $data['num']=DB::table('testLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',Auth::user()->id)
            ->count();
        return view('Mobile.user.test_history')->with($data);
    }
    //练习历史ajax获取
    public function ajaxGetTest(){
        $page=intval($_GET['page'])??1;
        if($page==1){
            return json_encode(['msg'=>'error']);
        }
        $data['test']=DB::table('testLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',Auth::user()->id)
            ->offset(($page-1)*$this->num)
            ->limit($this->num)
            ->get()
            ->toArray();
        $data['msg']='success';
        foreach($data['test'] as $k=>$v){
            $data['test'][$k]->time=date('Y.m.d',strtotime($v->time));
        }
        return json_encode($data);
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
            return response()
                ->view('Mobile.error', ['msg'=>'不存在该考试记录！','type'=>'error','url'=>'/wap/user/online_'.$type], 200);
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
        return view('Mobile.user.'.$view)->with($data);
    }
    //查看练习
    public function seeTest($eid){
        return $this->seeFile($eid,0);
    }
    //在线练习试题
    public function test($pid){
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
                    return response()
                        ->view('Mobile.error', ['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>'/wap/user/online_test'], 200);
                }
                $data['count']+=$data['pro']->exam_single;
            }
            if($data['pro']->exam_choose) {
                if(!$data['choose'] = $this->getChooseTest($data, $pid)){
                    return response()
                        ->view('Mobile.error', ['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>'/wap/user/online_test'], 200);
                }
                $data['count']+=$data['pro']->exam_choose;
            }
            if($data['pro']->judge_num) {
                if(!$data['judge'] = $this->getJudgeTest($data, $pid)){
                    return response()
                        ->view('Mobile.error', ['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>'/wap/user/online_test'], 200);
                }
                $data['count']+=$data['pro']->judge_num;
            }
            return view('Mobile.user.test')->with($data);
        }catch (\Exception $e){
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
    //教育档案
    public function archive($search=''){
        $data['user']=Auth::user();
        $data['pro']=Profession::select('professions.name as pname','e.value','e.time')
            ->leftJoin('examLog as e','e.pid','professions.id')
            ->where('e.uid',$data['user']->id)
            ->where('e.value','>=',60);
        if($search){
            $data['pro']=$data['pro']->where('professions.name','like','%'.$search."%");
        }
        $data['pro']=$data['pro']  ->groupBy('professions.id')
            ->get();
        $data['search']=$search;
        return view('Mobile.user.archive')->with($data);
    }
    //考核情况
    public function res(){
        $data['user']=Auth::user();
        $pro=Profession::select('professions.name as pname','e.value','e.time')
            ->leftJoin('examLog as e','e.pid','professions.id')
            ->where('e.uid',$data['user']->id)
            ->orderBy('e.value','desc')
            ->get();
        $arr=[];
        foreach($pro as $k=>$v){
            if(isset($arr[$v->pname])&&$arr[$v->pname]->value>$v->value){
                continue;
            }
            $arr[$v->pname]=$v;
        }
        $data['pro']=$arr;
        return view('Mobile.user.res')->with($data);
    }
    //错题库
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
        $data['exam']=$data['exam']->where('error.uid',$data['user']->id)
            ->get();
        $data['type']=$type;
        if($type==1)
            return view('Mobile.user.errorExam')->with($data);
        else
            return view('Mobile.user.errorExam_choose')->with($data);
    }
    //ajax获取错题
    public function ajaxGetError($type,$id){
        if($type==1) {
            $data = Exam::find($id);
        }else {
            $data = Exam_choose::find($id);
            $true=[];
            foreach($data->true as $v){
                $true[]=$data->$v;
            }
            $data->true=implode(',',$true);
        }
        return json_encode($data);
    }
    //删除错题
    public function delErrorExam($type,$id){
        if($type==1) {
            $field='eid';
        }else{
            $field='eChooseId';
        }
        if (DB::table('error_exams')->where($field, $id)->first()) {
            if (DB::table('error_exams')->where($field, $id)->delete()) {
                return response()
                    ->view('Mobile.error', ['msg' => '删除成功！', 'type' => 'error', 'url' => '/wap/user/errorExam/'.$type ], 200);
            }
        }
    }
    //在线考试
    public function online_exam(){
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
        return view('Mobile.user.online_exam')->with($data);
    }
    //考试历史
    public function exam_history(){
        $data['history']=DB::table('examLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',Auth::user()->id)
            ->limit($this->num)
            ->get();
        $data['num']=DB::table('examLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',Auth::user()->id)
            ->count();
        return view('Mobile.user.exam_history')->with($data);
    }
    //考试历史ajax获取
    public function ajaxGetExam(){
        $page=intval($_GET['page'])??1;
        if($page==1){
            return json_encode(['msg'=>'error']);
        }
        $data['test']=DB::table('examLog as e')
            ->select('e.*','p.name as pname','p.pic')
            ->join('professions as p','e.pid','p.id')
            ->where('e.uid',Auth::user()->id)
            ->offset(($page-1)*$this->num)
            ->limit($this->num)
            ->get()
            ->toArray();
        $data['msg']='success';
        foreach($data['test'] as $k=>$v){
            $data['test'][$k]->time=date('Y.m.d',strtotime($v->time));
        }
        return json_encode($data);
    }
    //在线考试试卷
    public function exam($pid){
        $data['user']=Auth::user();
        $data['pro']=Profession::find($pid);
        try {
            $p_time = Study::select(DB::raw('sum(video_num) as sum'))->where('pid', $pid)->get();
            $s_time = DB::table('study_time')
                ->select(DB::raw('sum(study_time) as sum'))
                ->where('pid', $pid)
                ->where('uid', $data['user']->id)->get();
            if ($p_time[0]->sum <= $s_time[0]->sum) {
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
                        return response()
                            ->view('Mobile.error', ['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>'/wap/user/online_test'], 200);
                    }
                    $data['count']+=$data['pro']->exam_single;
                }
                if($data['pro']->exam_choose) {
                    if(!$data['choose'] = $this->getChooseExam($data, $pid)){
                        return response()
                            ->view('Mobile.error', ['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>'/wap/user/online_test'], 200);
                    }
                    $data['count']+=$data['pro']->exam_choose;
                }
                if($data['pro']->judge_num) {
                    if(!$data['judge'] = $this->getJudgeExam($data, $pid)){
                        return response()
                            ->view('Mobile.error', ['msg'=>'考试题目还未上传完整，请耐心等待！','type'=>'error','url'=>'/wap/user/online_test'], 200);
                    }
                    $data['count']+=$data['pro']->judge_num;
                }
                return view('Mobile.user.exam')->with($data);
            }else{
                return response()
                    ->view('Mobile.error', ['msg' => '该门课程您还没有学习足够学时！', 'type' => 'error', 'url' => '/wap/user/online_exam' ], 200);
            }
        }catch (\Exception $e){
            return response()
                ->view('Mobile.error', ['msg' => '非法操作！', 'type' => 'error', 'url' => '/wap/user/online_exam' ], 200);
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
                }catch (\Exception $e){

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
                }catch (\Exception $e){

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
                }catch (\Exception $e){

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
    //提交练习试卷
    public function submitTest(Request $request){
        return $this->submit($request,'test');
    }
    //提交考试
    private function submit($request,$type){
        $examLog['uid']=$request->get('uid');
        if(strpos(url()->previous(),"/wap/user/{$type}/")===false||$request->method()!='POST'||$examLog['uid']!=Auth::user()->id){
            return response()
                ->view('Mobile.error', ['msg'=>'非法操作！','type'=>'error','url'=>'/wap/user/online_'.$type], 200);
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
    //ajax修改头像
    public function changPic(Request $request){
        $user=Auth::user();
        if(!$request->file('pic')->isValid()) {
            return json_encode(['error'=>1,'msg'=>'选择文件太大，请选择低于2M的文件上传！']);
        }
        $data['pic']=$request->pic->store('images/'.$user->id,'admin');
        if(User::where('id',$user->id)->update($data)){
            $status=self::checkUserStatus();
            if($status) {
                return json_encode(['error' => 0, 'msg' => "修改成功，信息已完善可以开始学习！"]);
            }else{
                return json_encode(['error' => 0, 'msg' => "修改成功，信息未完善，请继续完善个人信息！"]);
            }
        }else{
            return json_encode(['error'=>1,'msg'=>'修改有误！']);
        }
    }
    //ajax修改用户信息
    public function changData(Request $request){
        try {
            $user = Auth::user();
            $data[$request->field] = $request->value;
            if (User::where('id', $user->id)->update($data)) {
                $status=self::checkUserStatus();
                if($status) {
                    return json_encode(['error' => 0, 'msg' => "修改成功，信息已完善可以开始学习！"]);
                }else{
                    return json_encode(['error' => 0, 'msg' => "修改成功，信息未完善，请继续完善个人信息！"]);
                }
            } else {
                return json_encode(['error' => 1, 'msg' => '修改有误！']);
            }
        }catch (\Exception $e){
            return json_encode(['error' => 1, 'msg' => '修改有误！']);
        }
    }
    private static function checkUserStatus(){
        $user=Auth::user();
        if(!$user->status) {
            foreach (self::$info as $k => $v) {
                if ($user->$k == null) {
                    return false;
                }
            }
            if(!$user->pic&&!$user->wx_pic){
                return false;
            }
            User::whereId($user->id)->update(['status' => 1]);
        }
        return true;
    }
    //解除微信绑定
    public function loseWx(){
        if (strpos(Agent::getUserAgent(), 'MicroMessenger') !== false&&Auth::check()) {
            $user=Auth::user();
            User::where('id',$user->id)->update(['wx_openId'=>null,'wx_name'=>null,'wx_pic'=>null]);
            Auth::logout();
            return response()
                ->view('Mobile.error', ['msg'=>'解除微信绑定成功！','type'=>'success','url'=>'/wap']);
        }
        return response()
            ->view('Mobile.error', ['msg'=>'操作有误！','type'=>'error','url'=>'/wap/user/set']);
    }
}
