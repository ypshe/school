<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>个人中心</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body>
		<!--头部-->
		<div class="gerentop">
			<div class="header bglan overflow textcenter wbai">
				<a class="fl textcenter" href="/wap">
					<i class="iconfont icon-zuojiantou bai h1 b">
						
					</i>
				</a>
				<a class="fr h1 bai b" href="{{url('/wap/user/set')}}" style="font-size:7vw">
					<img style="width: 8vw; margin-top: 3vw;" src="/mobile/img/shezhi.png">
				</a>
			</div>
			<div class="touxiang textcenter">
				<a href="{{url('/wap/user')}}">
					<img src="@if($user->pic){{img_local($user->pic)}}@elseif($user->wx_pic){{$user->wx_pic}}@else /Pc/img/touxiang.png @endif">
					<span class="bai textcenter top20" style="font-size:4.6vw;">{{$user->name}}</span>
				</a>
			</div>
		</div>
		<!--头部-->
		<!--个人中心-->
		<article>
			<div class="dingdantop bgbai">
				<a class="overflow" href="">
					<img class="fl" src="/mobile/img/dingdan.png">
					<span class="fl san h2">我的订单</span>
					<i class="iconfont icon-youjiantou h1 b fr"></i>
				</a>
			</div>
			<div class="dingdanbo bgbai top20">
				<table class="wbai">
					<tr>
						<td>
							<a href="{{url('/wap/user/online_study')}}">
								<img src="/mobile/img/xuexi.png">
								<span class="textcenter h2 san top20">在线学习</span>
							</a>
						</td>
						<td>
							<a href="{{url('/wap/user/online_test')}}">
								<img src="/mobile/img/bi.png">
								<span class="textcenter h2 san top20">在线练习</span>
							</a>
						</td>
						<td>
							<a href="{{url('/wap/user/online_exam')}}">
								<img src="/mobile/img/kaoshi.png">
								<span class="textcenter h2 san top20">在线考试</span>
							</a>
						</td>
						<td>
							<a href="{{url('/wap/user/errorExam/1')}}">
								<img src="/mobile/img/cuotiku.png">
								<span class="textcenter h2 san top20">错题库</span>
							</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="{{url('/wap/user/res')}}">
								<img src="/mobile/img/jishiben.png">
								<span class="textcenter h2 san top20">考核情况</span>
							</a>
						</td>
						<td>
							<a href="{{url('/wap/user/file')}}">
								<img src="/mobile/img/ziliaoku.png">
								<span class="textcenter h2 san top20">资料库</span>
							</a>
						</td>
						<td>
							<a href="{{url('/wap/user/archive')}}">
								<img src="/mobile/img/dangan.png">
								<span class="textcenter h2 san top20">教育档案</span>
							</a>
						</td>
						<td>
							<a href="{{url('/wap/user/ask')}}">
								<img src="/mobile/img/liuyan.png">
								<span class="textcenter h2 san top20">在线留言</span>
							</a>
						</td>
					</tr>
					{{--<tr>--}}
						{{--<td>--}}
							{{--<a href="{{url('/wap/logout')}}">--}}
								{{--<img src="/mobile/img/liuyan.png">--}}
								{{--<span class="textcenter h2 san top20">安全退出</span>--}}
							{{--</a>--}}
						{{--</td>--}}
					{{--</tr>--}}
				</table>
			</div>
		</article>
		<!--个人中心-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script>
			
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>