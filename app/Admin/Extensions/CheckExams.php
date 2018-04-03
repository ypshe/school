<?php
/**
 * Created by PhpStorm.
 * User: v_ypshe
 * Date: 2018/4/2
 * Time: 11:07
 */

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Tools\BatchAction;

class CheckExams extends BatchAction
{
    protected $type;

    public function __construct()
    {
        $path=\Request::path();
        $type=0;
        if(strpos($path,'exam_choose')!==false)
            $type=1;
        if(strpos($path,'judge')!==false)
            $type=2;
        $this->type = $type;
    }

    public function script()
    {
        return <<<EOT

$('{$this->getElementClass()}').on('click', function() {

    $.ajax({
        method: 'post',
        url: '/admin/checkExams',
        data: {
            _token:LA.token,
            ids: selectedRows(),
            type: {$this->type}
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;

    }
}
