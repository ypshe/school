<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\Notice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class NoticeController extends Controller
{
    private $num=7;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['data']=Notice::orderBy('sort','desc')->limit($this->num)->get();
        foreach($data['data'] as $k=>$v){
            $data['data'][$k]->blurb=mb_strlen($v->blurb)>30?(mb_substr($v->blurb,0,30).'...'):$v->blurb;
        }
        $data['num']=Notice::count();
        return view('Mobile.notice')->with($data);
    }
    public function desc($id)
    {
        $data['data']=Notice::find($id);
        Notice::whereId($id)->increment('visit_num', 1);
        return view('Mobile.noticeDesc')->with($data);
    }
    public function ajaxGetData(){
        $page=intval($_GET['page'])??1;
        if($page==1){
            return json_encode(['msg'=>'error']);
        }
        $res=Notice::orderBy('sort','desc')
            ->offset(($page-1)*$this->num)
            ->limit($this->num)
            ->get()->toArray();
        foreach($res as $k=>$v){
            $res[$k]['blurb']=mb_strlen($v['blurb'])>30?(mb_substr($v['blurb'],0,30).'...'):$v['blurb'];
        }
        $data['msg']='success';
        $data['res']=$res;
        return json_encode($data);
    }
}
