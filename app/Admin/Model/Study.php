<?php

namespace App\Admin\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Study extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        Study:课程表：
//        {
//        id:课程id,
//        pid:专业id,
//        name:课程名,
//        tid:讲师id,
//        time:总学时,(s)
//        study_num:学习人数,
//        desc:课程简介,
//        created_at:创建时间,
//        updated_at:修改时间,
//        video_num:视频数,
//	      pic:封面图
//        section:章节(json)
//        }
        'pid','name','tid','time','desc','video_num','pic','section'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
