<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\Exam;
use App\Admin\Model\Profession;
use App\Admin\Model\Study;
use App\Admin\Model\User;
use App\Admin\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request,$id=null){
        $data['title']='培训课程';
        $data['data']['pro']=Profession::orderBy('sort','desc')->get();
        if(($request->method()=='POST')||($request->page&&session('search')&&$id==null)){
            $search=$request->method()=='POST'?'%'.$request->search.'%':'%'.session('search').'%';
            $data['data']['studies'] = Study::select('studies.*', 'teachers.name as tname', 'teachers.work as twork')
                ->leftJoin('teachers', 'studies.tid', 'teachers.id')
                ->leftJoin('professions','professions.id','studies.pid')
                ->where('studies.name', 'like', $search)
                ->orwhere('professions.name', 'like', $search)
                ->orderBy('sort', 'desc')
                ->paginate(12);
            $data['search'] = $request->method()=='POST' ? $request->search : session('search');
            session(['search'=>$data['search']]);
        }else {
            if ($id) {
                $data['data']['studies'] = Study::select('studies.*', 'teachers.name as tname', 'teachers.work as twork')
                    ->leftJoin('teachers', 'studies.tid', 'teachers.id')
                    ->where('studies.pid', $id)
                    ->orderBy('sort', 'desc')
                    ->paginate(12);
                $data['pid'] = $id;
            } else {
                $data['data']['studies'] = Study::select('studies.*', 'teachers.name as tname', 'teachers.work as twork')
                    ->leftJoin('teachers', 'studies.tid', 'teachers.id')
                    ->orderBy('sort', 'desc')
                    ->paginate(12);
            }
            $request->session()->forget('search');
        }
        return view('Pc.study')->with($data);
    }
    public function desc($id){
        $data['title']='课程详情';
        $data['study']=Study::select('studies.*','teachers.name as tname','teachers.work as twork','teachers.desc as tdesc')
            ->leftJoin('teachers','studies.tid','teachers.id')
            ->where('studies.id',$id)
            ->first();
        $data['orderStudy'] = Study::select('studies.*', 'teachers.name as tname', 'teachers.work as twork')
            ->leftJoin('teachers', 'studies.tid', 'teachers.id')
            ->orderBy('sort', 'desc')
            ->limit(5)
            ->get();
        $data['section']=json_decode($data['study']->section,true);
        $data['videos']=Video::where('sid',$id)->get();
        $data['study']['study_num']=DB::table('study_time')->where('sid',$id)->groupBy('uid')->count('uid');
        if(Auth::check()) {
            //进行学习的条件
            $res = DB::table('user_study')->where('uid',Auth::user()->id)->where('pid', $data['study']->pid)->first();
            $data['study_time_ids']=DB::table('study_time')->where('uid',Auth::user()->id)->where('sid', $id)->pluck('vid')->toArray();
        }else{
            $res=0;
        }
        if($res){
            $data['define']=0;
        }else{
            $data['define']=1;
        }
        return view('Pc.studyDesc')->with($data);
    }
    //播放视频
    public function video($vid){
        $data['title']='播放视频';
        return self::returnVideo($vid,0);
    }
    public function videoFirst($sid){
        $data['title']='开始学习';
        return self::returnVideo(0,$sid);
    }
    private static function returnVideo($vid,$sid){
        $data=[];
        if($vid){
            $data['video']=Video::find($vid);
        }
        if($sid){
            $data['video']=Video::where('sid',$sid)
                ->orderBy('section','asc')
                ->orderBy('sort','asc')
                ->first();
        }
        if(!$data['video']){
            $user=new UserController();
            return $user->error(['msg'=>'该课程还未上传视频，请耐心等待','type'=>'error','url'=>url('/study')]);
        }
        $data['study']=Study::find($data['video']->sid);
        $user_study=DB::table('user_study')->where('pid',$data['study']->pid)->where('uid',Auth::user()->id)->first();
        if(!$user_study){
            $user=new UserController();
            return $user->error(['msg'=>'您未报名参加该视频所属专业的课程，请先报名！','type'=>'error','url'=>url('/getStudy/'.$data['study']->pid)]);
        }
        $data['study_time_count']=DB::table('study_time')->select(DB::raw('count(id) as num'))
            ->where('uid',Auth::user()->id)
            ->where('sid',$data['study']->id)
            ->first();
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
        return view('Pc.video')->with($data);
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
        $data['title']='学时验证';
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
                    ->paginate(10);
                $allTime=DB::table('professions')
                    ->select('professions.id as pid',DB::raw('sum(studies.video_num) as allTime'))
                    ->join('studies','studies.pid','professions.id')
                    ->groupBy('professions.id')
                    ->limit(10)->get();
                $newAllTime=[];
                foreach($allTime as $k=>$v){
                    $newAllTime[$v->pid]=$v->allTime;
                }
                foreach($data['time'] as $k=>$v){
                    $data['time'][$k]->allTime=$newAllTime[$v->pid];
                }
            }else{
                $data['error']='不存在该用户';
            }
        }
        return view('Pc.getStudyTime')->with($data);
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
