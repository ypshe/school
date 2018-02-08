<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WorkController extends Controller
{
    public function index()
    {
        $data['title']='工作动态';
        $data['works']=Work::orderBy('sort','desc')->paginate(10);
        return view('Pc.work')->with($data);
    }
    public function desc($id)
    {
        $data['title']='工作动态详情';
        $data['work']=Work::find($id);
        Work::whereId($id)->increment('visit_num', 1);
        return view('Pc.workDesc')->with($data);
    }
}
