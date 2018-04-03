<div class="gerentop">
    <div class="gerentouxiang">
        <a href="{{url('/user')}}">
            <img src="{{$user->pic?img_local($user->pic):'/Pc/img/touxiang.png'}}">
        </a>
    </div>
    <span>{{$user->name}}</span>
</div>
<div class="gerenbo">
<div class="gerenbole">
    <?php $path = \Request::path(); ?>
    <dl>
        <dt>
            <i>
                <img src="/Pc/img/icongeren.png">
            </i>
            <span>学习中心</span>
        </dt>
        <dd>
            <a @if(strpos($path,'online_study')!==false)class="on"@endif href="{{url('/user/online_study')}}">
                <span>在线学习</span>
                <i></i>
            </a>
            <a @if(strpos($path,'online_test')!==false)class="on"@endif href="{{url('/user/online_test')}}">
                <span>在线练习</span>
                <i></i>
            </a>
            <a  @if(strpos($path,'online_exam')!==false)class="on"@endif href="{{url('/user/online_exam')}}">
                <span>在线考试</span>
                <i></i>
            </a>
            <a @if(strpos($path,'errorExam')!==false)class="on"@endif href="{{url('/user/errorExam')}}">
                <span>错题库</span>
                <i></i>
            </a>
            <a @if(strpos($path,'res')!==false)class="on"@endif href="{{url('/user/res')}}">
                <span>考核情况</span>
                <i></i>
            </a>
            <a @if(strpos($path,'ask')!==false)class="on"@endif  href="{{url('/user/ask')}}">
                <span>在线留言</span>
                <i></i>
            </a>
            <a @if(strpos($path,'file')!==false)class="on"@endif  href="{{url('/user/file')}}">
                <span>资料下载</span>
                <i></i>
            </a>
        </dd>
    </dl>
    <dl>
        <dt>
            <i>
                <img src="/Pc/img/icongeren02.png">
            </i>
            <span>个人中心</span>
        </dt>
        <dd>
            <a @if(strpos($path,'user/index')!==false)class="on" @endif href="{{url('/user/index')}}">
                <span>个人资料</span>
                <i></i>
            </a>
            <a href="">
                <span>订单管理</span>
                <i></i>
            </a>
            <a  @if(strpos($path,'archive')!==false)class="on"@endif href="{{url('/user/archive')}}">
                <span>教育档案</span>
                <i></i>
            </a>
        </dd>
    </dl>
    <dl>
        <dt>
            <i>
                <img src="/Pc/img/icongeren03.png">
            </i>
            <span>客服中心</span>
        </dt>
        <dd class="kefu">
            <a>
                <span>服务热线</span>
                <b>{{config('app.phone')}}</b>
                <img src="{{img_local(\App\Admin\Model\Banner::where('place','wx')->first()->src)}}">
                <span class="sao">扫一扫<br>手机也能看</span>
            </a>
        </dd>
    </dl>
</div>