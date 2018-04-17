<?php

namespace App\Admin\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Video extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        video:视频表
//        {
//        id:视频id,
//        sid:所属课程id,
//        url:视频地址,
//        name:名称,
//        sort:视频章节(越大越往后),
//        time:视频学时(s),
//        see_num:已观看人数,
//        created_at:上传时间
//        updated_at:修改时间
//        }
        'sid','url','name','sort','time','see_num','sort'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            // 在这里添加其他逻辑
            Study::whereId($model->sid)->decrement('video_num');
            Study::whereId($model->sid)->decrement('time',$model->time);
        });
    }
}
