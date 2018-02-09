<?php

namespace App\Admin\Controllers;

use App\Admin\Model\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
            $content->header('学生列表');
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
            $content->header('学生管理');
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
            $content->header('学生管理');
            $content->description('添加学生');
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
        return Admin::grid(User::class, function(Grid $grid){
            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('name', '姓名');
                $filter->like('sex', '性别');
                $filter->like('political', '政治面貌');
                $filter->like('nationality', '民族');

            });
            $grid->id('ID')->sortable();
            $grid->column('name','用户名');
            $grid->pic('个人照片')->image('',30,30);
            $grid->sex('性别')->display(function ($sex) {
                return $sex =='女'? '女' : '男';
            });
            $grid->political('政治面貌')->display(function ($political) {
                return $political =='群众'? '群众' : '党员';
            });
            $grid->phone('手机号');
            $grid->nationality('民族');
            $grid->where_c('籍贯')->display(function($where_c) {
                $addr=DB::table('addr')->whereId($where_c)->first();
                if($addr) {
                    $data = DB::table('addr')->select('name')->whereId($addr->upid)->first()->name . '-' . $addr->name;
                }
                return $data??'';
            });
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($uid=0)
    {
        return  Admin::form(User::class, function(Form $form) use ($uid){
            $form->display('id', 'ID');
            $form->text('name', '学生名')
                ->rules('required|regex:/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',[
                'regex' => '请输入正确的中文姓名,两到四个汉字',
                'required'=>'请输入用户名'
            ]);
            $form->mobile('phone','手机号')
                ->rules('regex:/^1[34578]{1}\d{9}$/',[
                'regex'=>'请输入正确的手机号',
            ]);
            $form->text('cardId', '身份证号')
                ->rules(function ($form) {
                    if (!$id = $form->model()->id) {
                        return 'required|unique:users,cardID|regex:/^\d{17}[0-9xX]{1}$/';
                    }else{
                        return 'required|regex:/^\d{17}[0-9xX]{1}$/';
                    }
                },[
                'regex'=>'请输入正确的18位身份证号',
                'unique'=>'身份证号已存在，请校验信息',
                'required'=>'请输入身份证号'
                ]);
            $form->image('pic', '个人照片');
            $addr = DB::table('addr')->where('type',3)->pluck('name','id')->toArray();
            $where_c=[];
            $home_c=[];
            $home_a=[];;
            if($uid){
                $data=DB::table('users')->whereId($uid)->first();
                $where_c= DB::table('addr')->where('upid',$data->where_p)->pluck('name','id')->toArray();
                $home_c = DB::table('addr')->where('upid',$data->home_p)->pluck('name','id')->toArray();
                $home_a = DB::table('addr')->where('upid',$data->home_c)->pluck('name','id')->toArray();
            }
            $form->select('where_p', '籍贯')->options($addr)->load('where_c', '/admin/api/addr')->setWidth(2);
            $form->select('where_c','')->options($where_c)->setWidth(2);
            $form->radio('sex','性别')->options(['男'=>'男','女'=>'女'])->default('男');
            $form->radio('political','政治面貌')->options(['群众'=>'群众','党员'=>'党员']);
            $form->select('home_p', '家庭住址')->options($addr)->load('home_c', '/admin/api/addr')->setWidth(2);
            $form->select('home_c','')->options($home_c)->load('home_a', '/admin/api/addr')->setWidth(2);
            $form->select('home_a','')->options($home_a)->setWidth(2);
            $form->text('home','')->placeholder('请输入详细家庭住址');
            $form->text('nationality', '民族')
                ->rules('regex:/^([\xe4-\xe9][\x80-\xbf]{2}){1,9}$/',[
                'regex' => '请输入正确的民族',
            ]);
//            $form->hidden('small_pic');
            $form->password('password', '密码')->placeholder('请设置学生登录密码，6-12位字符')
                ->rules('confirmed|required',[
                    'confirmed'=>'两次输入密码不相同',
                    'required'=>'请输入密码'
                ])->default(function ($form) {
                    return $form->model()->password;
                });
            $form->password('password_confirmation', '确认密码')->placeholder('请再次输入学生登录密码')->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });
            $form->ignore(['password_confirmation']);
            $form->saving(function (Form $form){
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
            $form->saved(function () {
                return redirect(admin_base_path('student'))->with(compact('添加成功！'));
            });
        });
    }
}
