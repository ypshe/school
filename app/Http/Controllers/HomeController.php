<?php

namespace App\Http\Controllers;

use App\Admin\Model\Exam;
use App\Admin\Model\Exam_choose;
use App\Admin\Model\Judge;
use Encore\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function addr(Request $request)
    {
        $q=$request->get('q');
        return DB::table('addr')->where('upid', $q)->get(['id','name']);
    }
    public function checkExam($id,$type){
        $res = 0;
        if(\Admin::user()) {
            switch ($type) {
                case 0:
                    if ($data = Exam::find($id)) {
                        $res=Exam::whereId($id)->update(['status'=>1]);
                    }
                    break;
                case 1:
                    if ($data = Exam_choose::find($id)->toArray()) {
                        $data['status'] = 1;
                        $res=Exam_choose::whereId($id)->update(['status'=>1]);
                    }
                    break;
                case 2:
                    if ($data = Judge::find($id)->toArray()) {
                        $data['status'] = 1;
                        $res=Judge::whereId($id)->update(['status'=>1]);
                    }
                    break;
            }
        }
        if($res){
            $success = new MessageBag([
                'title'   => '信息',
                'message' => '审核试题成功，试题已加入课程题库',
            ]);
            return back()->with(compact('success'));
        }else{
            $success = new MessageBag([
                'title'   => '信息',
                'message' => '审核失败',
            ]);
            return back()->with(compact('success'));
        }
    }
    public function checkExams(Request $request){
        $res=false;
        if($request->method()=='POST'){
            switch($request->type){
                case 0:
                    $res=Exam::whereIn('id',$request->ids)->update(['status'=>1]);
                    break;
                case 1:
                    $res=Exam_choose::whereIn('id',$request->ids)->update(['status'=>1]);
                    break;
                case 2:
                    $res=Judge::whereIn('id',$request->ids)->update(['status'=>1]);
                    break;
            }
        }
        return $res?1:0;
    }
}
