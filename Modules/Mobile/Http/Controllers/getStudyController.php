<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\ExamLog;
use App\Admin\Model\Profession;
use App\Admin\Model\Study;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class getStudyController extends Controller{
    public function index($pid=0){
        $data['title']='报名培训';
        if($pid){
            $data['pro']=Profession::find($pid);
            $study=Study::where('pid',$pid)->get();
            $data['study']=[];
            $data['study_time']=0;
            foreach($study as $v){
                $data['study'][]=$v->name;
                $data['study_time']+=$v->video_num;
            }
        }
        $user_pro=DB::table('user_study')->where('uid',Auth::user()->id)->pluck('pid');
        $data['pros']=Profession::whereNotIn('id',$user_pro)->get();
        return view('Mobile.getStudy')->with($data);
    }
    //确认报名
    public function confirm($pid){
        $data['user']=Auth::user();
        DB::table('user_study')->insert(['uid'=>$data['user']->id,'pid'=>$pid,'created_at'=>date('Y-m-d H:i:s'),'is_pay'=>0]);
        return response()
            ->view('Mobile.error',
                ['msg'=>'报名成功，可以开始该专业的课程学习！','type'=>'success','url'=>url('/wap/studyDesc/'.$pid)],
                200);
    }
    public function paste(){
        $data['paste']=ExamLog::where('value','>=',60)
            ->select('examLog.*','u.name as uname','a.name as home')
            ->leftJoin('users as u','examLog.uid','u.id')
            ->leftJoin('addr as a','u.where_c','a.id')
            ->groupBy('uid')->orderBy('time','desc')
            ->get();
        return view('Mobile.paste')->with($data);
    }
}