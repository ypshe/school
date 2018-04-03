<?php

namespace App\Http\Controllers;

use Encore\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index(Request $request){
        if (strpos($request->url(), 'mp4') !== false) {
            if(!\Encore\Admin\Facades\Admin::user()) {
                if(!Auth::check() || Auth::user()->status !== 1) {
                    return response()->file('../storage/app/aetherupload/define.mp4');
                }
            }
        }
        return response()->file(urldecode('..'.$request->getRequestUri()));
    }
}
