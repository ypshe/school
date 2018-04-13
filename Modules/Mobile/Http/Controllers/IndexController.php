<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\ExamLog;
use App\Admin\Model\Notice;
use App\Admin\Model\Study;
use App\Admin\Model\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        $data['study']=Study::select('studies.*','t.name as tname')
            ->leftJoin('teachers as t','studies.tid','t.id')
            ->orderBy('sort','desc')->limit(4)->get();
        $data['notice']=Notice::orderBy('sort','desc')->limit(3)->get();
        $data['work']=Work::orderBy('sort','desc')->limit(3)->get();
        $data['paste']=ExamLog::where('value','>=',60)
            ->select('examLog.*','u.name as uname','a.name as home')
            ->leftJoin('users as u','examLog.uid','u.id')
            ->leftJoin('addr as a','u.where_c','a.id')
            ->groupBy('uid')->orderBy('time','desc')->limit(20)->get();
        return view('Mobile.index')->with($data);
    }
    //首页搜索
    public function search(){
        return view('Mobile.search');
    }
    //错误页面
    public static function error($data=['msg'=>'操作有误！','type'=>'error','url'=>'/wap']){
        return view('Mobile.error')->with($data);
    }
}
