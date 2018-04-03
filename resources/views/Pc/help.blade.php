@extends('layout')
@section('content')
	<script src = '/packages/ueditor/ueditor.parse.js'></script>
	<!--主体部分-->
	<div class="main">
		<!--面包屑导航-->
		<div class="mianbao">
			<a href="{{url('/')}}">首页</a>
			<span>></span>
			<a href="{{url('/help/1')}}">帮助中心</a>
		</div>
		<style>
			img{
				display: inline;
			}
			p{
				font-style:normal;
				font-weight:normal;
			}
		</style>
		<!--面包屑导航-->
		<div class="gerenbox">
			<div class="gerenbo bangzhu">
				<div class="gerenbole" style="min-height: 847px;">
					<dl>
						<dd>
							<a href="{{url('/help/1')}}"  @if($type==1)class="on"@endif>
								<b></b>
								<span>培训流程</span>
								<i></i>
							</a>
							<a href="{{url('/help/2')}}"  @if($type==2)class="on"@endif>
								<b class="cao"></b>
								<span>操作演示</span>
								<i></i>
							</a>
							<a href="{{url('/help/3')}}"  @if($type==3)class="on"@endif>
								<b class="peixun"></b>
								<span>培训须知</span>
								<i></i>
							</a>
							<a href="{{url('/help/4')}}"  @if($type==4)class="on"@endif>
								<b class="lianxii"></b>
								<span>联系我们</span>
								<i></i>
							</a>
						</dd>
					</dl>
				</div>
				<div class="gerenbori bangzhuri" style="min-height: 847px;">
					@if($type==4)
						<div class="title">
							<h2>联系我们</h2>
						</div>
						<div class="lianximo">
							<div class="lianximole">
								<h3>河南省长垣县职业技术学校</h3>
								<span>电话：{{config('app.phone')}}</span>
								<span>地址：{{config('app.school')}}</span>
							</div>
							<div class="lianximori">
								<img src="{{img_local($wx->src)}}">
								<span>微信公众号</span>
							</div>
						</div>
						<div class="lianxibob">
							<div id="map"></div>
						</div>
					@elseif($type==1)
						<div class="title">
							<h2>培训流程</h2>
						</div>
						<div class="showData">
							{!! $data?$data->content:'' !!}
						</div>
					@elseif($type==2)
						<div class="title">
							<h2>操作演示</h2>
						</div>
						<div class="showData">
							{!! $data?$data->content:'' !!}
						</div>
					@elseif($type==3)
						<div class="title">
							<h2>培训须知</h2>
						</div>
						<div class="showData">
							{!! $data?$data->content:'' !!}
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	@if($type==4)
		<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
		<script>
            init();
            function init(){
                // 地图的中心地理坐标。
                var center = new qq.maps.LatLng(35.190141,114.722988);
                var map = new qq.maps.Map(document.getElementById('map'),{
                    center: center,
                    zoom: 13
                });
                //创建marker
                var marker = new qq.maps.Marker({
                    position: center,
                    map: map
                });
                var marker = new qq.maps.Label({
                    position: center,
                    map: map,
                    content:'河南省长垣县职业技术学校'
                });
            }
		</script>
	@endif

	@if($type!==4)
		<script>
            $(function(){
                $('.showData').css('padding','5px');
                uParse('.showData',{
                    rootPath: '/packages/ueditor'
                });
            });
		</script>
	@endif
@endsection