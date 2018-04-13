<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\Exam;
use App\Admin\Model\ExamLog;
use App\Admin\Model\Notice;
use App\Admin\Model\Profession;
use App\Admin\Model\Study;
use App\Admin\Model\User;
use App\Admin\Model\Video;
use App\Admin\Model\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    private $num=8;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function delSearch(Request $request){
        $request->session()->forget('wap_search');
    }
    public function pro(){
        $data['pro']=Profession::orderBy('sort', 'desc')->get();
        return view('Mobile.pro')->with($data);
    }
    public function index($type='',$info=''){
        if($type==2){
            $data['title'] = $info;
            $search='%'.$info.'%';
            $data['study'] = Study::select('studies.*', 't.name as tname')
                ->leftJoin('teachers as t', 'studies.tid', 't.id')
                ->leftJoin('professions','professions.id','studies.pid')
                ->where(function ($query) use($search){
                    $query->where('studies.name', 'like', $search)
                        ->orwhere('professions.name', 'like', $search);
                })
                ->orderBy('sort', 'desc')
                ->limit($this->num)
                ->get();
            if(!$data['study']){
                return response()
                    ->view('Mobile.error', ['msg'=>'课程不存在，请选择其他课程！','type'=>'error','url'=>'/wap/study'], 200);
            }
            $data['num'] = intval(ceil(Study::where('studies.pid', $info)->leftJoin('teachers as t', 'studies.tid', 't.id')
                    ->leftJoin('professions','professions.id','studies.pid')
                    ->where(function ($query) use($search){
                        $query->where('studies.name', 'like', $search)
                            ->orwhere('professions.name', 'like', $search);
                    })->count() / $this->num));
            if($session=session('wap_search')){
                $session=json_decode($session,true);
                if(!in_array($data['title'],$session))
                    $session[]=$data['title'];
                session(['wap_search'=>json_encode($session)]);
            }else{
                $session[]=$data['title'];
                session(['wap_search'=>json_encode($session)]);
            }
        }elseif($type==1){
            $pro=Profession::find($info);
            if($pro) {
                $data['study'] = Study::select('studies.*', 't.name as tname')
                    ->leftJoin('teachers as t', 'studies.tid', 't.id')
                    ->where('studies.pid', $info)
                    ->orderBy('sort', 'desc')
                    ->limit($this->num)
                    ->get();
                $data['num'] = intval(ceil(Study::where('studies.pid', $info)->count() / $this->num));
                $data['title'] =$pro->name;
            }else{
                return response()
                    ->view('Mobile.error', ['msg'=>'专业不存在，请选择其他专业课程！','type'=>'error','url'=>'/wap/pro'], 200);
            }
        }else {
            $data['study'] = Study::select('studies.*', 't.name as tname')
                ->leftJoin('teachers as t', 'studies.tid', 't.id')
                ->orderBy('sort', 'desc')
                ->limit($this->num)
                ->get();
            $data['num'] = intval(ceil(Study::count() / $this->num));
        }
        return view('Mobile.study')->with($data);
    }
    //下拉ajax获取数据
    public function ajaxGetStudy(){
        $page=intval($_GET['page'])??1;
        if($page==1){
            return json_encode(['msg'=>'error']);
        }
        $study=Study::select('studies.*','t.name as tname')
            ->leftJoin('teachers as t','studies.tid','t.id')
            ->orderBy('sort','desc')
            ->offset(($page-1)*$this->num)
            ->limit($this->num)
            ->get()->toArray();
        $data['msg']='success';
        $data['study']=$study;
        return json_encode($data);
    }
    //培训详情
    public function studyDesc($id){
        $data['study'] = Study::find($id);
        $data['videos'] = Video::where('sid', $id)->get();
        $data['study']->section = json_decode($data['study']->section);
        //进行学习的条件
        if(Auth::check()) {
            $res = DB::table('user_study')->where('uid',Auth::user()->id)->where('pid', $data['study']->pid)->first();
        }else{
            $res=0;
        }
        if($res){
            $data['define']=0;
        }else{
            $data['define']=1;
        }
        return view('Mobile.studyDesc')->with($data);
    }
    //播放视频
    public function video($vid,$status=''){
        return self::returnVideo($vid,0);
    }
    public function videoFirst($sid,$status=''){
        return self::returnVideo(0,$sid);
    }
    private static function returnVideo($vid,$sid){
        $data=[];
        if($sid){
            $data['video']=Video::where('sid',$sid)
                ->orderBy('section','asc')
                ->orderBy('sort','asc')
                ->first();
        }
        if($vid){
            $data['video']=Video::find($vid);
            $sid=$data['video']->sid;
        }
        $data['study']=Study::find($sid);
        if(!$data['video']){
            return response()
                ->view('Mobile.error',
                    ['msg'=>'该课程还未上传视频，请耐心等待！','type'=>'error','url'=>url('/wap/studyDesc/'.$sid)],
                    200);
        }
        $user_study=DB::table('user_study')->where('pid',$data['study']->pid)->where('uid',Auth::user()->id)->first();
        if(!$user_study){
            return response()
                ->view('Mobile.error',
                    ['msg'=>'您未报名参加该视频所属专业的课程，请先报名！','type'=>'error','url'=>url('/wap/getStudy/'.$data['study']->pid)],
                    200);
        }
        $data['question']=Exam::where('vid',$data['video']->id)->first();
        //打乱题目
        if($data['question']) {
            $choose = [$data['question']->choose_1, $data['question']->choose_2, $data['question']->choose_3, $data['question']->choose_4];
            shuffle($choose);
            shuffle($choose);
            $data['question']->choose_1 = array_pop($choose);
            $data['question']->choose_2 = array_pop($choose);
            $data['question']->choose_3 = array_pop($choose);
            $data['question']->choose_4 = array_pop($choose);
            //获取正确选项
            switch ($data['question']->true) {
                case $data['question']->choose_1:
                    $data['question']->select = 'A';
                    break;
                case $data['question']->choose_2:
                    $data['question']->select = 'B';
                    break;
                case $data['question']->choose_3:
                    $data['question']->select = 'C';
                    break;
                case $data['question']->choose_4:
                    $data['question']->select = 'D';
                    break;
            }
        }
        $data['section']=json_decode($data['study']->section,true);
        $data['videos']=Video::where('sid',$data['study']->id)->get();
        return view('Mobile.video')->with($data);
    }
    public function userError(Request $request){
        $data=$request->all();
        //处理错题
        $data['uid']=Auth::id();
        $data['created_time']=date('Y-m-d H:i:s');
        $data['eChooseId']=0;
        if(!DB::table('error_exams')->where([['uid','=',$data['uid']], ['eid','=',$data['eid']]])->first())
            DB::table('error_exams')->insert($data);
    }
    public function userStudy(Request $request){
        $data=[];
        $data['uid']=Auth::id();
        $vid=$request->get('vid');
        $end=$request->get('res');
        //处理学时
        $study_time=DB::table('study_time')->where('uid',$data['uid'])->where('vid',$vid)->first();
        $res=Video::select('videos.time as time','studies.id as sid','professions.id as pid')
            ->leftjoin('studies','studies.id','videos.sid')
            ->leftjoin('professions','studies.pid','professions.id')
            ->where('videos.id',$vid)
            ->first();
        if($res) {
            if ($study_time) {
                if($end){
                    $update = [
                        'study_time' => 1,
                    ];
                    DB::table('study_time')->where('uid', $data['uid'])->where('vid', $vid)->update($update);
                }
            }else{
                $insert = [
                    'uid' => $data['uid'],
                    'vid' => $vid,
                    'sid' => $res->sid,
                    'pid' => $res->pid,
                    'study_time' => $end ? 1 : (1 / 2),
                    'join_time' => date('Y-m-d H:i:s')
                ];
                DB::table('study_time')->insert($insert);
            }
        }
        echo true;
    }
    public function getStudyTime($cardId=''){
        $data['cardId']=$cardId??'';
        if($cardId){
            $data['user']=User::where('cardId',$cardId)->first();
            if($data['user']){
                $data['time']=DB::table('professions')
                    ->select('professions.id as pid',DB::raw('max(study_time.join_time) as addTime'),DB::raw('sum(study_time.study_time) as time'))
                    ->join('study_time','study_time.pid','professions.id')
                    ->join('studies','studies.id','study_time.sid')
                    ->where('study_time.uid',$data['user']->id)
                    ->groupBy('professions.id')
                    ->get();
                $allTime=DB::table('professions')
                    ->select('professions.id as pid',DB::raw('sum(studies.video_num) as allTime'))
                    ->join('studies','studies.pid','professions.id')
                    ->groupBy('professions.id')
                    ->get();
                $newAllTime=[];
                foreach($allTime as $k=>$v){
                    $newAllTime[$v->pid]=$v->allTime;
                }
                foreach($data['time'] as $k=>$v){
                    $data['time'][$k]->allTime=$newAllTime[$v->pid];
                }
            }else{
                return response()
                    ->view('Mobile.error',
                        ['msg'=>'不存在该用户！','type'=>'error','url'=>'/wap/getStudyTime/'.$cardId],
                        200);
            }
        }
        return view('Mobile.getStudyTime')->with($data);
    }
    public function getTimeDesc($pid,$cardId){
        if($cardId&&$pid){
            $data['user']=User::where('cardId',$cardId)->first();
            if($data['user']){
                $study=DB::table('study_time')
                    ->select('studies.name as sname','videos.section as section','videos.sort as vsort','study_time.*')
                    ->join('studies','study_time.sid','studies.id')
                    ->join('videos','videos.id','study_time.vid')
                    ->where('study_time.uid',$data['user']->id)
                    ->where('study_time.pid',$pid)
                    ->get()
                    ->toArray();
            }else{
                return  '不存在该用户';
            }
        }else{
            return 'error';
        }
        return json_encode($study);
    }
}
