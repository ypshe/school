<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\CheckExam;
use App\Admin\Extensions\CheckExams;
use App\Admin\Model\Exam_choose;

use App\Admin\Model\Profession;
use App\Admin\Model\Video;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class Exam_chooseController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Request $request)
    {
        return Admin::content(function (Content $content) use($request){
            $vid=$request->get('vid');
            if($vid){
                $video=Video::find($vid);
                $content->header('单选题');
                $content->description('视频：'.$video->name);

                $content->body($this->grid($vid));
            }else {
                $content->header('单选题');
                $content->description('试题列表');

                $content->body($this->grid());
            }
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

            $content->header('单选题');
            $content->description('修改试题');

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

            $content->header('单选题');
            $content->description('新增试题');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($vid=0)
    {
        return Admin::grid(Exam_choose::class, function (Grid $grid) use($vid){
            if($vid)
                $grid->model()->where('vid',$vid);
            $grid->id('ID')->sortable();
            $grid->info('问题')->limit(30);
            $grid->true('正确答案')->display(function($true){
                $true=implode(',',$true);
                return $true;
            })->limit(30);
            $grid->pid('所属专业')->display(function($pid){
                return Profession::find($pid)->name;
            });
            $grid->status('审核状态')->display(function($status){
                return $status?'已审核':'未审核';
            });
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
            $grid->actions(function ($actions) {
                if($actions->row->status==0) {
                    // append一个操作
                    $actions->prepend(new CheckExam($actions->getKey()));
                }
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->add('审核通过', new CheckExams());
                });
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
        return Admin::form(Exam_choose::class, function (Form $form)use($id) {
            $form->display('id', 'ID');
            $form->text('info', '题目')
                ->rules('required',[
                    'required'=>'请输入题目'
                ]);
            $form->text('choose_1', '选项1')
                ->rules('required|different:choose_2,choose_3,choose_4',[
                    'required'=>'请输入选项1',
                    'different'=>'选项之间不能相同'
                ])->placeholder('请输入选项1，必填项');
            $form->text('choose_2', '选项2')
                ->rules('required|different:choose_1,choose_3,choose_4',[
                    'required'=>'请输入选项2',
                    'different'=>'选项之间不能相同'
                ])->placeholder('请输入选项2，必填项');
            $form->text('choose_3', '选项3')
                ->rules('required|different:choose_1,choose_2,choose_4',[
                    'required'=>'请输入选项3',
                    'different'=>'选项之间不能相同'
                ])->placeholder('请输入选项3，必填项');
            $form->text('choose_4', '选项4')
                ->rules('required|different:choose_1,choose_2,choose_3',[
                    'required'=>'请输入选项4',
                    'different'=>'选项之间不能相同'
                ])->placeholder('请输入选项4，必填项');
            $form->text('choose_5', '选项5')
                ->rules('different:choose_1,choose_2,choose_3,choose_4',[
                    'different'=>'选项之间不能相同'
                ]);
            $form->text('choose_6', '选项6')
                ->rules('different:choose_1,choose_2,choose_3,choose_4',[
                    'different'=>'选项之间不能相同'
                ]);
            $form->text('choose_7', '选项7')
                ->rules('different:choose_1,choose_2,choose_3,choose_4',[
                    'different'=>'选项之间不能相同'
                ]);
            $form->html('<span style="color:red">注意：多选题选项在4-7个之间（选项1-选项4为必填项，选项5-选项7可自主选择填写与否），需要几个选项则填写几个选项，余出的不填。且在正确选项栏中选择所有正确的选项。</span>');
            if($id){
                $data=Exam_choose::find($id)->toArray();
                $checked=[];
                foreach($data as $k=>$v){
                    foreach($data['true'] as $vv){
                        if($vv==$v&&strpos($k,'choose')!==false) {
                            $checked[] =$k;
                        }
                    }
                }
                $form->checkbox('true', '正确答案')
                    ->rules('required', [
                        'required' => '请选择正确答案'
                    ])
                    ->options([
                        'choose_1' => '选项1',
                        'choose_2' => '选项2',
                        'choose_3' => '选项3',
                        'choose_4' => '选项4',
                        'choose_5' => '选项5',
                        'choose_6' => '选项6',
                        'choose_7' => '选项7',
                    ]);
            }
            else {
                $form->checkbox('true', '正确答案')
                    ->rules('required', [
                        'required' => '请选择正确答案'
                    ])
                    ->options([
                        'choose_1' => '选项1',
                        'choose_2' => '选项2',
                        'choose_3' => '选项3',
                        'choose_4' => '选项4',
                        'choose_5' => '选项5',
                        'choose_6' => '选项6',
                        'choose_7' => '选项7',
                    ]);
            }
            $form->select('pid', '所属专业')
                ->options(Profession::pluck('name', 'id'))
                ->load('sid', '/admin/api/getStudy')
                ->rules('required', [
                    'required' => '请选择所属专业'
                ])
                ->setWidth(2);
            $form->saving(function(Form $form){
                $form->choose_5=$form->choose_5??'';
                $form->choose_6=$form->choose_6??'';
                $form->choose_7=$form->choose_7??'';
                $true=[];
                foreach($form->true as $v){
                    if($form->$v){
                        $true[]=$v;
                    }
                }
                $form->true=$true;
            });

        });
    }
}
