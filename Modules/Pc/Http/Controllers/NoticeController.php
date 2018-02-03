<?php

namespace Modules\Pc\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('Pc.notice');
    }
    public function desc($id)
    {
        return view('Pc.noticeDesc');
    }
}
