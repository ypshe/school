<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>分类</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body>
		<!--头部-->
		<header>
			<img class="fl" src="/mobile/img/logo.png">
			<a class="iconfont icon-search fr h2 c9 b" href="{{url('/wap/search')}}"></a>
		</header>
		<!--头部-->
		<!--分类-->
		<article class="bgbai top20">
			<ul class="fenlei">
				@foreach($pro as $k=>$v)
					<li>
						<a href="{{url('/wap/study/1/'.$v->id)}}" class="overflow">
							<span class="fl liu h3">{{$v->name}}</span>
							<i class="fr iconfont icon-youjiantou h1"></i>
						</a>
					</li>
				@endforeach
			</ul>
		</article>
		<!--分类-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>