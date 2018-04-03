<footer class="overflow wbai bgbai">
    <?php $path = \Request::path(); ?>
    <a class="w25 textcenter fl @if($path=='wap')on @endif" href="{{url('/wap')}}">
        <i class="iconfont icon-shouye san h1 b"></i>
        <span class="san h3 textcenter">
					首页
				</span>
    </a>
    <a class="w25 textcenter fl @if(strpos($path,'study')!==false)on @endif" href="{{url('/wap/pro')}}">
        <i class="iconfont icon-shuben san h1 b"></i>
        <span class="san h3 textcenter">
					专业
				</span>
    </a>
    <a class="w25 textcenter fl @if(strpos($path,'help')!==false)on @endif" href="{{url('/wap/help/1')}}">
        <i class="iconfont icon-bangzhu san h1 b"></i>
        <span class="san h3 textcenter">
					帮助
				</span>
    </a>
    <a class="w25 textcenter fl @if(strpos($path,'user')!==false)on @endif" href="{{url('/wap/user')}}">
        <i class="iconfont icon-wode san h1 b"></i>
        <span class="san h3 textcenter">
					我的
				</span>
    </a>
</footer>