<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Study;
use App\Admin\Model\Video;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Library\FFmpeg;
use function GuzzleHttp\Promise\unwrap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class VideoController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Request $request)
    {
        $sid=$request->get('sid')??0;
        return Admin::content(function (Content $content)use($sid){
            if($sid){
                $content->header('视频列表');
                $content->description('课程：'.Study::find($sid)->name);
            }else {
                $content->header('视频管理');
                $content->description('视频列表');
            }
            $content->body($this->grid($sid));
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('视频管理');
            $content->description('修改视频');

            $content->body($this->form($id)->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('视频管理');
            $content->description('添加视频');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($sid)
    {
        return Admin::grid(Video::class, function (Grid $grid)use($sid) {
            if($sid){
               $grid->model()->where('sid',$sid);
            }
            $grid->id('ID')->sortable();

            $grid->name('视频名称');
            $grid->sid('所属课程')->display(function($sid){
                return Study::find($sid)->name;
            });
            $grid->nav('所属篇章')->display(function($nav){
                $data=explode('-',$nav);
                return '第'.($data[1]+1).'章：'.json_decode(Study::find($data[0])->section,true)[$data[1]];
            });
            $grid->sort('所属小节')->display(function($sort){
                return '第'.($sort).'节';
            });
            $grid->url('视频')->display(function($sort){
                return '<video class="kv-preview-data" width="213px" height="160px" controls="">
                        <source src="'.Storage::disk(config('admin.upload.disk'))->url($sort).'" type="video/mp4">
                            <div class="file-preview-other">
                                <span class="file-other-icon"><i class="glyphicon glyphicon-file"></i></span>
                            </div>
                        </video>
                    ';
            });
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
            $grid->actions(function ($actions) {
                $id=$actions->getKey();
                // prepend一个操作
                $actions->prepend('<a href="'.url('admin/exam?vid='.$id).'"><i class="fa fa-paper-plane"></i>查看视频问题</a>');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=0)
    {
        return Admin::form(Video::class, function (Form $form)use($id) {
            $form->display('id', 'ID');
            $form->text('name', '视频名称')
                ->rules('required',[
                    'required'=>'请输入视频名称'
                ]);
            $form->select('sid','所属课程')
                ->options(Study::all()->pluck('name','id'))
                ->load('section', '/admin/api/section')
                ->setWidth(3);
            if($id) {
                $form->select('section', '篇章')->options(function () use($id){
                    $section = json_decode(Study::whereId(Video::find($id)->sid)->select('section')->first()->section, true);
                    foreach ($section as $k => $v) {
                        $section[$k] = '第' . ($k + 1) . '章:' . $v;
                    }
                    return $section;
                })->rules('required|regex:/^\d+$/', [
                    'required' => '请输入视频篇章',
                    'regex' => '请输入一个数字，用作表示该章的第几小结'
                ]);
            }else {
                $form->select('section','篇章')
                    ->rules('required|regex:/^\d+$/',[
                    'required'=>'请输入视频篇章',
                    'regex'=>'请输入一个数字，用作表示该章的第几小结'
                ]);
            }
            $form->text('sort', '章节')->rules('regex:/^\d+$/',['regex'=>'请输入一个整数']);
            if($id){
                $form->display('url','原视频')->with(function ($value) {
                    return '<video class="kv-preview-data" width="213px" height="160px" controls="">
                        <source src="'.Storage::disk(config('admin.upload.disk'))->url($value).'" type="video/mp4">
                            <div class="file-preview-other">
                                <span class="file-other-icon"><i class="glyphicon glyphicon-file"></i></span>
                            </div>
                        </video>
                    ';
                });
                $form->file('url2', '新视频')->rules('mimes:mp4', [
                    'mines' => '文件格式须为MP4',
                ])->move('/video/' . date('Ymd'), time() . rand(1, 100) . '.mp4');
            }else {
                $form->file('url', '上传视频')->rules('mimes:mp4', [
                    'mines' => '文件格式须为MP4',
                ])->move('/video/' . date('Ymd'), time() . rand(1, 100) . '.mp4');
            }
            $form->hidden('time');
            $form->hidden('nav');
            $form->saving(function(Form $form){
                if(!$form->url) {
                    if ($form->url2) {
                        $form->url = $form->url2;
                        $video_time = json_decode(FFmpeg::getVideoInfo($form->url))->play_time;
                        $form->time = $video_time;
                        Study::whereId($form->sid)->increment('time', ($video_time-$form->model()->time));
                    } else {
                        unset($form->inputs['url']);
                        unset($form->inputs['time']);
                    }
                    unset($form->inputs['url2']);
                }else {
                    $video_time = json_decode(FFmpeg::getVideoInfo($form->url))->play_time;
                    $form->time = $video_time;
                    Study::whereId($form->sid)->increment('time', $video_time);
                }
                $form->nav = $form->sid . '-' .$form->section.'-'. $form->sort;

            });
            $form->saved(function(){
                return redirect('/admin/video')->with('操作成功');
            });
        });
    }
}
