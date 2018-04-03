<!DOCTYPE html>
<html class="bgbai">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>正在跳转...</title>
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
			<h3 class="sanwu bai textcenter">@if($type=='error')错误@else成功@endif</h3>
		</div>
		<!--头部-->
		<!--异常-->
		<article>
			<img style="width:44.4vw;margin-top:30vw" src="/mobile/img/chucuo.jpg">
			<span class="h1 san textcenter top40">{{$msg}}</span>
			<span class="h6 top40 san textcenter"><b class="miaozhong" style="font-weight: 400;">5</b>秒钟后跳转，点击<a style="display: inline-block;" class="lancolor" href="{{$url}}">立即跳转</a></span>
		</article>
		<!--异常-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script>
			//5秒后跳转
			var wait = 5;
			function time() {
				if (wait == 0) {
				    window.location="{{$url}}"
				} else { 
					$(".miaozhong").text(wait);
				    wait--;
				    setTimeout(function() {
				       time()
				    },
				    1000)
				}
			}
			time();
		</script>
	</body>

</html>