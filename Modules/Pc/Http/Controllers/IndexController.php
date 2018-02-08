<?php

namespace Modules\Pc\Http\Controllers;

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

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request){
        $data['title']='首页';
        $data['data']['proSix']=Profession::orderBy('sort','desc')->limit(6)->get()->toArray();
        $data['data']['studies']=Study::select('studies.*','teachers.name as tname','teachers.work as twork')
            ->leftJoin('teachers','studies.tid','teachers.id')
            ->orderBy('sort','desc')
            ->limit(4)
            ->get();
        $data['notices']=Notice::orderBy('sort','desc')->limit(6)->get();
        $data['works']=Work::orderBy('sort','desc')->limit(6)->get();
        $data['banner']=\App\Admin\Model\Banner::where('place','banner')->orderBy('sort','desc')->limit(3)->get();
        return view('Pc.index')->with($data);
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}
