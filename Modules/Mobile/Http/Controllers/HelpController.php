<?php

namespace Modules\Mobile\Http\Controllers;

use App\Admin\Model\Banner;
use App\Admin\Model\Help;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($type=4){
        $data=[];
        switch ($type){
            case 1:
                //培训流程
                $data['type']=1;
                $data['title']='培训流程';
                $data['data']=Help::where('type','liucheng')->first();
                break;
            case 2:
                //操作演示
                $data['type']=2;
                $data['title']='操作演示';
                $data['data']=Help::where('type','yanshi')->first();
                break;
            case 3:
                //培训须知
                $data['type']=3;
                $data['title']='培训须知';
                $data['data']=Help::where('type','xuzhi')->first();
                break;
            case 4:
                $data['title']='联系我们';
                $data['wx']=Banner::where('place','wx')->orderBy('sort','desc')->first();
                $data['type']=4;
                break;
        }
        return view('Mobile.help')->with($data);
    }
}
