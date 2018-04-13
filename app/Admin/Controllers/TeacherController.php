<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Teacher;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TeacherController extends Controller
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

            $content->header('教师管理');
            $content->description('教师列表');

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

            $content->header('教师管理');
            $content->description('修改信息');

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

            $content->header('教师管理');
            $content->description('新增教师');

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
        return Admin::grid(Teacher::class, function (Grid $grid) {
            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('name', '教师姓名');

            });

            $grid->id('ID')->sortable();
            $grid->name('教师姓名');
            $grid->pic('个人照片')->image('',30,30);
            $grid->sex('性别')->display(function ($sex) {
                return $sex =='女'? '女' : '男';
            });
            $grid->work('职位');
            $grid->desc('简介')->limit(20);
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($uid=0)
    {
        return Admin::form(Teacher::class, function (Form $form) use ($uid){
            $form->display('id', 'ID');
            $form->text('name', '教师姓名')
                ->rules('required|regex:/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',[
                    'regex' => '请输入正确的中文姓名,两到四个汉字',
                    'required'=>'请输入教师名'
                ]);
            $form->radio('sex','性别')->options(['男'=>'男','女'=>'女'])->default('男');
            $form->text('work', '教师职位')
                ->rules('required|regex:/^([\xe4-\xe9][\x80-\xbf]{2})+$/',[
                    'regex' => '请输入正确格式的职位，须为汉字',
                    'required'=>'请输入教师职位'
                ]);
            $form->image('pic', '教师照片')->resize('413','295');
            $form->textarea('desc', '教师简介')
                ->rules('required',[
                    'required' => '请输入教师简介',
                ]);
//            $form->display('created_at', 'Created At');
//            $form->display('updated_at', 'Updated At');
        });
    }
}
