<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\CheckExams;
use App\Admin\Model\Judge;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Model\Profession;
use App\Admin\Extensions\CheckExam;

class JudgeController extends Controller
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

            $content->header('判断题');
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

            $content->header('判断题');
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

            $content->header('判断题');
            $content->description('新建');

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
        return Admin::grid(Judge::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->info('题目内容');
            $grid->is_true('是否正确')->display(function($is_true){
                return $is_true?'正确':'错误';
            });
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
    protected function form()
    {
        return Admin::form(Judge::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('info','题目内容');
            $form->radio('is_true','是否正确')->options([0=>'错误',1=>'正确']);
            $form->select('pid', '所属专业')
                ->options(Profession::pluck('name', 'id'))
                ->load('sid', '/admin/api/getStudy')
                ->rules('required', [
                    'required' => '请选择所属专业'
                ])
                ->setWidth(2);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
