<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Profession;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;

class ProfessionController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('专业管理');
            $content->description('专业列表');

            $content->body($this->grid());
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

            $content->header('专业管理');
            $content->description('修改专业');

            $content->body($this->form()->edit($id));
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

            $content->header('专业管理');
            $content->description('新增专业');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Profession::class, function (Grid $grid) {
            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('name', '专业名称');

            });
            $grid->id('ID')->sortable();
            $grid->name('专业名称');
            $grid->grade('专业评分');
            $grid->sort('专业权重');
            $grid->price('报名价格');
            $grid->join_num('参加人数');
            $grid->pic('专业封面图')->image('','120','100');
            $grid->desc('专业简介')->limit(20);
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
            $grid->actions(function ($actions) {
                $id=$actions->getKey();
                // prepend一个操作
                $actions->prepend('<a href="'.url('admin/exam?pid='.$id).'"><i class="fa fa-paper-plane"></i>查看专业题库</a>');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Profession::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '专业名称')
                ->rules('required|regex:/^([\xe4-\xe9][\x80-\xbf]{2})+$/',[
                    'regex' => '请输入正确的专业名称，必须为汉字',
                    'required'=>'请输入专业名称'
                ]);
            $form->text('sort', '专业权重')
                ->rules('required|regex:/^\d+$/',[
                    'regex' => '请输入正确的专业权重，如：3',
                    'required'=>'专业权重'
                ])->placeholder('请输入专业权重，权重越大排列越靠前,格式为整数');
            $form->text('price', '报名价格')
                ->rules('required|regex:/^\d+$/',[
                    'regex' => '请输入正确的报名价格，如：6500',
                    'required'=>'专业权重'
                ])->placeholder('请输入报名价格，格式为整数');
            $form->image('pic', '专业封面图')->resize('262','161');
            $form->image('icon', '专业图标')->resize('16','16');
            $form->textarea('desc', '专业简介')
                ->rules('required',[
                    'required' => '请输入专业简介',
                ]);
            $form->divide();
            $form->html('', '以下为该专业考试设置：');
            $form->text('exam_time', '考试时间')
                ->rules('required|integer',[
                    'integer' => '请输入正确的考试时间，必须为整数',
                    'required'=>'请输入专业名称'
                ])->placeholder('请输入考试时间，整数，单位为分钟');
            $form->text('exam_single', '单选题数量')
                ->rules('required|integer',[
                'integer' => '请输入正确的单选题数量，必须为整数',
                'required'=>'请输入单选题数量'
            ]);
            $form->text('single_value', '单选题分数')
                ->rules('required|integer',[
                    'integer' => '请输入正确的单选题分数，必须为整数',
                    'required'=>'请输入单选题分数'
                ]);
            $form->text('exam_choose', '多选题数量')
                ->rules('required|integer',[
                    'integer' => '请输入正确的多选题数量，必须为整数',
                    'required'=>'请输入多选题数量'
                ]);
            $form->text('choose_value', '多选题分数')
                ->rules('required|integer',[
                    'integer' => '请输入正确的多选题分数，必须为整数',
                    'required'=>'请输入多选题分数'
                ]);
            $form->text('judge_num', '判断题数量')
                ->rules('required|integer',[
                    'integer' => '请输入正确的判断题数量，必须为整数',
                    'required'=>'请输入判断题数量'
                ]);
            $form->text('judge_value', '判断题分数')
                ->rules('required|integer',[
                    'integer' => '请输入正确的判断题分数，必须为整数',
                    'required'=>'请输入判断题分数'
                ]);
            $form->saving(function(Form $form){
                if(($form->single_value*$form->exam_single+$form->exam_choose*$form->choose_value+$form->judge_num*$form->judge_value)!==100){
                    $error = new MessageBag([
                        'title'   => '信息',
                        'message' => '所有题目的分数之和必须为100！',
                    ]);
                    return back()->with(compact('error'));
                }
            });
        });
    }
}
