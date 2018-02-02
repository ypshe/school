<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Profession;
use App\Admin\Model\Study;

use App\Admin\Model\Teacher;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class StudyController extends Controller
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

            $content->header('课程管理');
            $content->description('课程列表');

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

            $content->header('课程管理');
            $content->description('修改课程');

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

            $content->header('课程管理');
            $content->description('添加课程');

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
        return Admin::grid(Study::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('课程名称');
            $grid->pid('课程名称')->display(function($pid) {
                return Profession::find($pid)->name;
            });
            $grid->tid('授课教师')->display(function($tid) {
                return Teacher::find($tid)->name;
            });
            $grid->pic('封面图')->image('',100,80);
            $grid->time('课程学时')->display(function($tid){
                return number_format(($tid/(60*60)),2).'小时';
            });
            $grid->desc('课程简介')->limit(20);
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
            $grid->actions(function ($actions) {
                $actions->prepend('<a href="'.url('admin/video?sid='.$actions->getKey()).'"><i class="fa fa-eye"></i>查看视频</a>');
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
        return Admin::form(Study::class, function (Form $form)use($id) {
            $form->display('id', 'ID');
            $form->text('name', '课程名称')
                ->rules('required|regex:/^([\xe4-\xe9][\x80-\xbf]{2})+$/',[
                    'regex' => '请输入正确的课程名称,格式为汉字',
                    'required'=>'请输入课程名称'
                ]);
            $form->select('pid','选择所属专业')
                ->options(Profession::all()->pluck('name', 'id'))
                ->setWidth(3);
            $form->select('tid','选择授课教师')
                ->options(Teacher::all()->pluck('name', 'id'))
                ->setWidth(3);
            if($id){
                $form->display('section','课程章节')->with(function ($value) {
                    return '<textarea name="section" class="form-control" rows="5" placeholder="请输入课程章节,用中文逗号隔开,输入顺序为章节顺序" value="为什么有猪，先有蛋还是先有鸡，鸡蛋有多重">'.implode('，',json_decode($value,true)).'</textarea> ';
                });
            }else {
                $form->textarea('section', '课程章节')
                    ->rules('required', [
                        'required' => '请输入课程章节',
                    ])->placeholder('请输入课程章节,用中文逗号隔开,输入顺序为章节顺序');
            }
            $form->image('pic', '课程封面图')->resize('262','161');
            $form->textarea('desc', '课程简介')
                ->rules('required',[
                    'required' => '请输入课程简介',
                ]);
            $form->saving(function($form){
                $form->section=json_encode(explode('，',$form->section));
            });
        });
    }
}
