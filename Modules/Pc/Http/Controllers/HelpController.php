<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\Banner;
use App\Admin\Model\Help;
use App\Admin\Model\Notice;
use App\Admin\Model\Profession;
use App\Admin\Model\Study;
use App\Admin\Model\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Svg\Style;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($type){
        $data['title']='帮助中心';
        switch ($type){
            case 1:
                //培训流程
                $data['type']=1;
                $data['data']=Help::where('type','liucheng')->first();
                break;
            case 2:
                //操作演示
                $data['type']=2;
                $data['data']=Help::where('type','yanshi')->first();
                break;
            case 3:
                //培训须知
                $data['type']=3;
                $data['data']=Help::where('type','xuzhi')->first();
                break;
            case 4:
                $data['wx']=Banner::where('place','wx')->orderBy('sort','desc')->first();
                $data['type']=4;
                break;
        }
        return view('Pc.help')->with($data);
    }
}
