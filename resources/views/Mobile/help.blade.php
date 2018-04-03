<!DOCTYPE html>
<html class="bgbai">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>帮助中心</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body class="bgbai">
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">帮助中心</h3>
			<a class="iconfont icon-wo fr h1 bai b" href="{{url('/wap/user')}}" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--帮助中心-->
		<article>
			<div class="bangzhutop overflow">
				<a href="{{url('/wap/help/1')}}" class="fl w25 h2 san textcenter @if($type==1)on @endif">
					培训流程
				</a>
				<a href="{{url('/wap/help/2')}}" class="fl w25 h2 san textcenter @if($type==2)on @endif">
					操作演示
				</a>
				<a href="{{url('/wap/help/3')}}" class="fl w25 h2 san textcenter @if($type==3)on @endif">
					培训须知
				</a>
				<a href="{{url('/wap/help/4')}}" class="fl w25 h2 san textcenter @if($type==4)on @endif">
					联系我们
				</a>
			</div>
			<div class="bangzhubo">
				<div class="title">
					<span class="fl h2">
						{{$title}}
					</span>
				</div>
				@if($type==4)
					<div class="h2 liu top20">
						河南省长垣县职业技术学校
					</div>
					<div class="h2 liu top20" style="line-height: 6vw;">
						电话：{{config('app.phone')}}</br>
						地址：{{config('app.school')}}
					</div>
					<div class="map top20" id="map">

					</div>
					<div class="textcenter lancolor h2 top20">
						<img src="{{img_local($wx->src)}}">
						微信公众号
					</div>
				@else
					<?php echo $data?$data->content:'';?>
				@endif
			</div>
		</article>
		<!--帮助中心-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
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
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>