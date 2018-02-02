<?php

namespace App\Admin\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        teacher:讲师表
//        {
//        id:讲师id,
//        name:讲师名（js校验2-4个中文）,
//        create_at:创建时间,
//        updated_at:修改时间,
//        pic:头像,（文件框，能显示图片最好）
//        sex:性别,（radio）
//        work:职位,
//        desc:简介
//        }
        'name','pic','sex','work','desc'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
