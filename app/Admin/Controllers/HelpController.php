<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Help;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class HelpController extends Controller
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

            $content->header('帮助中心');
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

            $content->header('帮助中心');
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

            $content->header('帮助中心');
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
        return Admin::grid(Help::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->type('帮助类型')->display(function ($sex) {
                switch($sex){
                    case 'xuzhi':
                        return '培训须知';
                    case 'yanshi':
                        return '操作演示';
                    case 'liucheng':
                        return '培训流程';
                }
            });
            $grid->uid('创建人')->display(function($uid){
                return DB::table('admin_users')->find($uid)->name;
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
        return Admin::form(Help::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->radio('type','帮助类型')->options(['xuzhi'=>'培训须知','yanshi'=>'操作演示','liucheng'=>'培训流程'])->default('xuzhi');
            $form->editor('content','动态内容');
            $form->hidden('uid');
            $form->saving(function(Form $form){
                $data=Help::where('type',$form->type)->first();
                if($data&&($data->id!==$form->model()->id)){
                    $error = new MessageBag([
                        'title'   => '错误.',
                        'message' => '该类型已存在',
                    ]);
                    return back()->with(compact('error'));
                }
                $form->uid=Admin::user()->id;
            });

        });
    }
}
