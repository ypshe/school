<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Profession;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

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
            $form->text('grade', '专业评分')
                ->rules('required|regex:/^\d+\.(\d{1})$/',[
                    'regex' => '请输入正确的专业评分，如：9.8',
                    'required'=>'请输入专业名称'
                ])->placeholder('请输入专业评分，格式小于10的一位小数，如9.8');
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
            $form->textarea('desc', '专业简介')
                ->rules('required',[
                    'required' => '请输入专业简介',
                ]);
        });
    }
}
