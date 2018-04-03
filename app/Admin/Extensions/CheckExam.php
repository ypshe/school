<?php
/**
 * Created by PhpStorm.
 * User: v_ypshe
 * Date: 2018/4/2
 * Time: 11:07
 */

namespace App\Admin\Extensions;
use Encore\Admin\Admin;

class CheckExam{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function render()
    {
        $path=\Request::path();
        $type=0;
        if(strpos($path,'exam_choose')!==false)
            $type=1;
        if(strpos($path,'judge')!==false)
            $type=2;
        return "<a href='/admin/checkExam/{$this->id}/{$type}'><i class='fa fa-check'></i>审核通过</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}