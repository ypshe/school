<!DOCTYPE html>
<html class="bgbai">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>搜索</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body class="bgbai">
		<!--登录头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<div class="search overflow bgbai">
				<i class="iconfont icon-search fl liu h1 textcenter"></i>
				<input class="fl liu h2" type="text" id="sousuo" placeholder="请输入关键词" />
			</div>
			<a id="search" class="fr bai textcenter h2" href="javascript:;">搜索</a>
		</div>
		<!--登录头部-->
		<!--搜索历史-->
		<div class="lishi">
			<ul>
				@if(session('wap_search'))
					@foreach(\GuzzleHttp\json_decode(session('wap_search')) as $k=>$v)
						<li class="overflow">
							<i class="fl iconfont icon-time jiu h2"></i>
							<a href="/wap/study/2/{{$v}}" class="fl liu h2">
								{{$v}}
							</a>
							<i class="fr iconfont icon-error jiu h2 shanchu"></i>
						</li>
					@endforeach
				@endif
			</ul>
			<div class="textcenter liu h2" id="qingkong" style="margin-top:4vw">清空历史记录</div>
		</div>
		<!--搜索历史-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script>
			$('#search').click(function(){
			    location.href='/wap/study/2/'+$('#sousuo').val();
			});
			$("#sousuo").focus(function(){
				$(".lishi").show();
				$(".shanchu").click(function(){
					$(this).parent("li").remove();
				});
				$("#qingkong").click(function(){
					$(".lishi").remove();
				});
			})
			$('#qingkong').click(function(){
			    $.ajax({
					url:'/wap/delSearch',
					type:'get'
				});
			});
		</script>
	</body>

</html>