<?php

namespace App\Admin\Controllers;

use App\Admin\Model\File;

use App\Admin\Model\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
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

            $content->header('资料管理');
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

            $content->header('资料管理');
            $content->description('修改');

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

            $content->header('资料管理');
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
        return Admin::grid(File::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->filename('文件名');
            $grid->path('文件地址');
            $grid->uid('上传人')->display(function($uid){
                if($this->is_admin==1){
                    return DB::table('admin_users')->find($uid)->name;
                }else{
                    return User::find($uid)->name;
                }
            });
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');

            $grid->actions(function ($actions){
                // prepend一个操作
                $actions->prepend(
                    '<a onclick="javascript:location.href=\''.url('/admin/download/'.$actions->row->path).'\'"><i class="fa fa-paper-plane"></i>下载</a>'
                );
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id='')
    {
        return Admin::form(File::class, function (Form $form) use($id){
            if($id) {
                $data = File::find($id);
            }
            if(isset($data)&&$data->is_admin!=1){
                $form->display('id', 'ID');
                $form->display('user2', '用户名')->default(User::find($data->uid)->name);
                $form->display('filename', '文件名称');
                $form->display('path', '选择文件');
                $form->disableSubmit();
            }else {
                $form->display('id', 'ID');
                $form->text('filename', '文件名称')
                    ->rules('required', [
                        'required' => '请输入文件名称'
                    ]);
                $form->file('path', '选择文件')
                    ->rules('required', [
                        'required' => '请选择需要上传的文件'
                    ])->move('/files');
                $form->hidden('uid');
                $form->hidden('is_admin');
                $form->saving(function (Form $form) {
                    $form->uid = Admin::user()->id;
                    $form->is_admin = 1;
                });
            }
        });
    }
    public function downloadFile($filename){
        return response()->download('../storage/uploads/files/'.$filename);
    }
}
