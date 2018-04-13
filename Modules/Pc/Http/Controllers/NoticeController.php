<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\Notice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['title']='培训公告';
        $data['notices']=Notice::orderBy('sort','desc')->paginate(10);
        return view('Pc.notice')->with($data);
    }
    public function desc($id)
    {
        $data['title']='培训公告详情';
        $data['notice']=Notice::find($id);
        Notice::whereId($id)->increment('visit_num', 1);
        return view('Pc.noticeDesc')->with($data);
    }
}
