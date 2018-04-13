<?php

namespace App\Admin\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profession extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        id:专业id,
//        name:专业名,
//        grade:评分,
//        sort:权重,
//        desc:简介,
//        price:报名价格,
//        created_at:创建时间,
//        updated_at:修改时间
        'name','sort','desc','price','grade'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
