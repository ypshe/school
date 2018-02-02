<?php
/**
 * Created by PhpStorm.
 * User: v_ypshe
 * Date: 2018/2/2
 * Time: 17:07
 */
namespace App\Http\Controllers;
use App\Library\Tools;
use Modules\Pc\Http\Controllers\IndexController;
class HomeController extends Controller{
    public function index(){
        if(Tools::isMobile()){
            return redirect('mobile');
        }else{
            $pc=new IndexController();
            return $pc->index();
        }
    }
}