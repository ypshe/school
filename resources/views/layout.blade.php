<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <title>{{$title}}</title>
    <link rel="stylesheet" href="{{ URL::asset('/Pc/css/base.css') }}" />
    <link rel="stylesheet" href="/Pc/css/index.css" />
    <script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js" ></script>
    <script type="text/javascript" src="/Pc/js/base.js"></script>
    <script type="text/javascript" src="/vendor/layer/layer.js"></script>
    <link rel="stylesheet" href="/Pc/css/gerenzhongxin.css" />
    @if(strpos(\Request::path(), 'help')===false)
        <link rel="stylesheet" href="{{ URL::asset('/Pc/css/base_start.css') }}" />
    @else
        <link rel="stylesheet" href="{{ URL::asset('/Pc/css/base_help.css') }}" />
    @endif
</head>
<body>
<?php
$pros=App\Admin\Model\Profession::orderBy('sort','desc')->get()->toArray();
foreach($pros as $k=>$v){
    $pros[$k]['studies']=App\Admin\Model\Study::select('studies.*','teachers.name as tname')
        ->leftJoin('teachers','studies.tid','teachers.id')
        ->where('pid',$v['id'])->limit(6)->get();
}
$wx=\App\Admin\Model\Banner::where('place','wx')->orderBy('sort','desc')->first();
?>
<!--公共头部-->
<div class="top">
    <div class="toptext">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="/Pc/img/logo.png">
            </a>
        </div>
        <div class="login" style="margin-top: 80px">
            @if(\Illuminate\Support\Facades\Auth::id())
                <a href="{{url('/user')}}">
                    欢迎您，{{\Illuminate\Support\Facades\Auth::user()->name}}
                </a>
            @else
                <a  href="{{url('/login')}}">
                    登录
                </a>
                <span>/</span>
                <a  href="{{url('/register')}}">
                    注册
                </a>
            @endif
            <i>
                @if(\Illuminate\Support\Facades\Auth::id())
                    <img onclick="javascript:window.location.href='{{url('/user')}}'" width="28" height="29" src="@if(\Illuminate\Support\Facades\Auth::user()->pic){{img_local(\Illuminate\Support\Facades\Auth::user()->pic)}}@else /Pc/img/icon02.jpg @endif">
                @else
                    <img src="/Pc/img/icon02.jpg">
                @endif
            </i>
        </div>
    </div>
</div>
<!--导航部分-->
<div class="navbox @if($_SERVER['REQUEST_URI']==='/'||$_SERVER['REQUEST_URI']==='/home') indexs @endif">
    <div class="nav">
        <div class="navle">
            <!--全部课程-->
            <div class="allmenu">
                <i class="allmi">
                    <img src="/Pc/img/icon01.png">
                </i>
                <span class="allmenuH">全部专业</span>
                <div class="all qita" @if($_SERVER['REQUEST_URI']==='/'||$_SERVER['REQUEST_URI']==='/home')style="display: block;"@endif>
                    @foreach(array_slice($pros,0,10) as $v)
                        <dl>
                            <a href="{{url('/study/'.$v['id'])}}">
                                <dt>
                                    <i>
                                        <img src="@if($v['icon']){{img_local($v['icon'])}} @else /Pc/img/icon14.png @endif">
                                    </i>
                                </dt>
                                <dd>
                                    {{$v['name']}}
                                </dd>
                            </a>
                                <!--右边分类-->
                                <div class="allRight">
                                    <ul>
                                        @foreach($v['studies'] as $vv)
                                            <li>
                                                <a href="">
                                                    <div class="allRightle">
                                                        <img src="{{img_local($vv->pic)}}">
                                                    </div>
                                                    <div class="allRightri">
                                                        {{$vv->name}}
                                                        <br/><br/>
                                                        <color style="color:#999999">讲师：{{$vv->tname}}</color>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            <!--右边分类-->
                        </dl>
                    @endforeach
                    <dl style="border-bottom: none;">
                        <a href="{{url('/study')}}">
                            <dt>
                                <i>
                                    <img src="/Pc/img/icon14.png">
                                </i>
                            </dt>
                            <dd>
                                其他课程
                            </dd>
                        </a>
                        <!--右边分类-->
                        <div class="allRight">
                            <div class="allRighttop">
                                @foreach(array_slice($pros,10) as $v)
                                    <a href="{{url('study/'.$v['id'])}}">
                                        {{$v['name']}}
                                    </a>
                                @endforeach
                            </div>
                            <ul>
                                <li>
                                    <a href="">
                                        <div class="allRightle">
                                            <img src="/Pc/img/img.jpg">
                                        </div>
                                        <div class="allRightri">
                                            前端进阶：响应式开发与常用框架
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--右边分类-->
                    </dl>
                </div>
            </div>
            <!--全部课程-->
            <div class="navmo">
                <a @if($_SERVER['REQUEST_URI']==='/')class="on"@endif  href="{{url('/')}}">首页</a>
                <a @if(strstr($_SERVER['REQUEST_URI'],'/study')!==false)class="on"@endif  href="{{url('/study')}}">培训课程</a>
                <a @if(strstr($_SERVER['REQUEST_URI'],'/time')!==false)class="on"@endif  href="{{url('/time')}}">学时验证</a>
                <a @if(strstr($_SERVER['REQUEST_URI'],'/notice')!==false)class="on"@endif  href="{{url('/notice')}}">通知公告</a>
                <a @if(strstr($_SERVER['REQUEST_URI'],'/work')!==false)class="on"@endif  href="{{url('/work')}}">工作动态</a>
                <a @if(strstr($_SERVER['REQUEST_URI'],'/help')!==false)class="on"@endif  href="{{url('/help/1')}}">帮助中心</a>
            </div>
        </div>
        <!--搜索-->
        <form class="searchbox" method="post" action="{{url('/study?page=1')}}">
            <div class="search">
                <input name="search" type="text" value="@if(isset($search)){{$search}}@endif" placeholder="搜索课程" />
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button type="submit" id="search">
                    <img src="/Pc/img/icon03.png">
                </button>
            </div>
            <!--搜索历史-->
            <div class="searchhistory">
                <h4>热门搜索</h4>
                <a href="">UI设计</a>
                <a href="">UI设计</a>
                <a href="">UI设计</a>
                <a href="">UI设计</a>
                <a href="">UI设计</a>
                <a href="">UI设计</a>
            </div>
            <!--搜索历史-->
        </form>
        <!--搜索-->
    </div>
</div>
<!--导航部分-->

<!--banner部分-->
@yield("content")
<!--公共底部-->
<div class="footer">
    <div class="footertext">
        <div class="footertextle">
            <ul>
                <li>
                    <a href="{{url('/study')}}">培训课程</a>
                    <span>|</span>
                    <a href="{{url('/time')}}">学时验证</a>
                    <span>|</span>
                    <a href="{{url('/notice')}}">通知公告</a>
                    <span>|</span>
                    <a href="{{url('/work')}}">工作动态</a>
                    <span>|</span>
                    <a href="{{url('/help')}}">帮助中心</a>
                    <span>|</span>
                    <a href="{{url('/tel')}}">联系我们</a>
                </li>
                <li style="margin-top:14px;margin-bottom: 14px;">
                    <a href="http://webscan.360.cn/index/checkwebsite/url/www.apanclub.cn" name="3428a484ac1bae206d56c216f941cd23" >360网站安全检测平台</a>&nbsp;&nbsp;{{config('app.web_num')}}&nbsp;&nbsp;Copyright © 2018-2019 , All Rights Reserved
                </li>
                <li>
                    <img style="display: inline" src="/police.png" alt="">&nbsp;{!! config('app.police_num') !!}&nbsp;&nbsp;长垣职业中等专业学校继续教育培训平台  版权所有
                </li>
            </ul>
        </div>
        <div class="footertextri">
            <img src="{{img_local($wx->src)}}">
            <span>微信公众号</span>
        </div>
    </div>
</div>
</body>

</html>