<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WorkController extends Controller
{
    private $num=7;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['data']=Work::orderBy('sort','desc')->limit($this->num)->get();
        foreach($data['data'] as $k=>$v){
            $data['data'][$k]->blurb=mb_strlen($v->blurb)>30?(mb_substr($v->blurb,0,30).'...'):$v->blurb;
        }
        $data['num']=Work::count();
        return view('Mobile.work')->with($data);
    }
    public function desc($id)
    {
        $data['data']=Work::find($id);
        Work::whereId($id)->increment('visit_num', 1);
        return view('Mobile.workDesc')->with($data);
    }
    public function ajaxGetData(){
        $page=intval($_GET['page'])??1;
        if($page==1){
            return json_encode(['msg'=>'error']);
        }
        $res=Work::orderBy('sort','desc')
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
