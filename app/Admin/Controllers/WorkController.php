<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Work;
use App\Admin\Model\User;
use Encore\Admin\Controllers\AuthController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
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

            $content->header('工作动态');
            $content->description('列表');

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

            $content->header('工作动态');
            $content->description('修改');

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

            $content->header('工作动态');
            $content->description('新增');

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
        return Admin::grid(Work::class, function (Grid $grid) {
            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('title', '动态标题');

            });

            $grid->id('ID')->sortable();
            $grid->pic('展示图片')->image('',100,80);
            $grid->title('动态标题');
            $grid->showAuthor('作者/发布人');
            $grid->sort('动态权重');
            $grid->uid('创建人')->display(function($uid){
                return DB::table('admin_users')->find($uid)->username;
            });
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Work::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title','动态标题');
            $form->text('showAuthor','作者/发布人');
            $form->textarea('blurb','动态简介');
            $form->text('sort','动态权重');
            $form->image('pic', '展示图片');
            $form->editor('content','动态内容');
            $form->hidden('uid');
            $form->hidden('visit_num');
            $form->saving(function(Form $form){
                $form->uid=Admin::user()->id;
                $form->visit_num=0;
            });
        });
    }
}
