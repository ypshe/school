<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Study;
use App\Admin\Model\Video;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(Dashboard::title());

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
        });
    }
    public function addr(Request $request)
    {
        $q=$request->get('q');
        return DB::table('addr')->where('upid', $q)->get(['id', DB::raw('name as text')]);
    }
    public function section(Request $request)
    {
        $q=$request->get('q');
        $section=\GuzzleHttp\json_decode(Study::whereId($q)->select('section')->first()->section,true);
        $arr=[];
        foreach($section as $k=>$v){
            $arr[$k]['text']='第'.($k+1).'章:'.$v;
            $arr[$k]['id']=$k;
        }
        return $arr;
    }
    public function getStudy(Request $request)
    {
        return Study::where('pid', $request->get('q'))->get(['id', DB::raw('name as text')]);
    }
    public function getVideo(Request $request)
    {
        $data=Video::where('sid', $request->get('q'))->get(['id', DB::raw('name as text')])->toArray();
        array_unshift($data,['id'=>0,'text'=>'不属于视频问题']);
        return $data;
    }
}
