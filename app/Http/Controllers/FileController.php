<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(Request $request){
        $request->getRequestUri();
//        if(strstr($request->url(),'storage/uploads/video')!==false) {
//            return response()->file('../storage/uploads/video/define.mp4');
//        }
        return response()->file('..'.$request->getRequestUri());
    }
}
