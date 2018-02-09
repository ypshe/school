<?php

namespace App\Http\Controllers;

use Encore\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index(Request $request){
        $request->getRequestUri();
        if (strstr($request->url(), 'storage/uploads/video') !== false) {
            if(! \Encore\Admin\Facades\Admin::user()) {
                if(!Auth::check() || Auth::user()->status !== 1) {
                    return response()->file('../storage/uploads/video/define.mp4');
                }
            }
        }
        return response()->file(urldecode(base_path($request->getRequestUri())));
    }
}
