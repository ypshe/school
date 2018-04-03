<?php

namespace Modules\Pc\Http\Controllers;

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
            $data['study']=implode(',',$data['study']);
        }
        $user_pro=DB::table('user_study')->where('uid',Auth::user()->id)->pluck('pid')->toArray();
        if(in_array($pid,$user_pro)){
            $user=new UserController();
            return $user->error(['msg'=>'您已报名参加该门课程，可以直接学习！','type'=>'success','url'=>url('/study/'.$pid)]);
        }
        $data['pros']=Profession::whereNotIn('id',$user_pro)->get();
        return view('Pc.getStudy')->with($data);
    }
    //确认报名
    public function confirm($pid){
        $data['user']=Auth::user();
        DB::table('user_study')->insert(['uid'=>$data['user']->id,'pid'=>$pid,'created_at'=>date('Y-m-d H:i:s'),'is_pay'=>0]);
        $user=new UserController();
        return $user->error(['msg'=>'报名成功，可以开始该专业的课程学习！','type'=>'success','url'=>url('/study/'.$pid)]);
    }
}