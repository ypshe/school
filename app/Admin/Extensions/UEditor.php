<?php
namespace App\Admin\Extensions;
use Encore\Admin\Form\Field;
class Ueditor extends Field
{
    protected $view = 'admin.ueditor';
    protected static $css = [
    ];
    protected static $js = [
        '/packages/ueditor/ueditor.config.js',
        '/packages/ueditor/ueditor.all.js',
        '/packages/ueditor/ueditor.parse.js',
    ];
    public function render()
    {
        $cs=csrf_token();
        $this->script = <<<EOT
        UE.delEditor('{$this->id}');
        var ue = UE.getEditor('{$this->id}');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '$cs'); 
        });
EOT;
        return parent::render();
    }
}