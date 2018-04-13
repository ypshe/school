<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Ask;

use App\Admin\Model\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;

class AskController extends Controller
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

            $content->header('用户留言');
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

            $content->header('用户留言');
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

            $content->header('用户留言');
            $content->description('创建');

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
        return Admin::grid(Ask::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->content('留言内容');
            $grid->uid('留言人')->display(function ($uid) {
                return User::find($uid)->name;
            });
            $grid->return('回复内容')->display(function ($return){
                return $return??'未回复';
            });
            $grid->returnMid('回复人')->display(function ($returnMid){
                if($returnMid){
                    return DB::table('admin_users')->whereId($returnMid)->first()->name;
                }else{
                    return '未回复';
                }
            });
            $grid->status('状态')->display(function ($status){
                return $status==0?'未回复':'已回复';
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
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
        return Admin::form(Ask::class, function (Form $form) {
            $form->text('content','留言内容')->readOnly();
            $form->text('return','回复内容');
            $form->radio('status','是否废弃')->options([1=>'否',2=>'是'])->default(1);
            $form->hidden('returnMid');
            $form->saving(function($form){
                $form->status=$form->status??1;
                $form->returnMid=Admin::user()->id;
                $form->updated_at=date('Y-m-d H:i:s',time());
            });
        });
    }
}
