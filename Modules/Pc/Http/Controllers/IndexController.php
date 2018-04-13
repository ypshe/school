<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\ExamLog;
use App\Admin\Model\Notice;
use App\Admin\Model\Profession;
use App\Admin\Model\Study;
use App\Admin\Model\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Facades\Agent;
use Svg\Style;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request){
        if(Agent::isMobile()){
            return redirect('/wap');
        }
        $data['title']='长垣职业中等专业学校继续教育培训平台';
        $data['data']['proSix']=Profession::orderBy('sort','desc')->limit(6)->get()->toArray();
        $data['data']['studies']=Study::select('studies.*','teachers.name as tname','teachers.work as twork')
            ->leftJoin('teachers','studies.tid','teachers.id')
            ->orderBy('sort','desc')
            ->limit(4)
            ->get();
        $data['notices']=Notice::orderBy('sort','desc')->limit(6)->get();
        $data['works']=Work::orderBy('sort','desc')->limit(6)->get();
        $data['banner']=\App\Admin\Model\Banner::where('place','banner')->orderBy('sort','desc')->limit(3)->get();
        //最新考试通过名单
        $data['paste']=ExamLog::where('value','>=',60)
            ->select('examLog.*','u.name as uname','a.name as home')
            ->leftJoin('users as u','examLog.uid','u.id')
            ->leftJoin('addr as a','u.where_c','a.id')
            ->groupBy('uid')->orderBy('time','desc')->limit(20)->get();
        return view('Pc.index')->with($data);
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}
