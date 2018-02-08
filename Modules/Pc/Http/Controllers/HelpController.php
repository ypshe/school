<?php

namespace Modules\Pc\Http\Controllers;

use App\Admin\Model\Banner;
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
                $data['type']=1;
                break;
            case 2:
                $data['type']=2;
                break;
            case 3:
                $data['type']=3;
                break;
            case 4:
                $data['wx']=Banner::where('place','wx')->orderBy('sort','desc')->first();
                $data['type']=4;
                break;
        }
        return view('Pc.help')->with($data);
    }
}
