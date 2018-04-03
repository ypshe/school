<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>教育档案</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
		<style>
			.title{
				padding:2vw 2.4vw;
			}
		</style>
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">教育档案</h3>
			<a class="iconfont icon-wo fr h1 c9 b" href="" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--个人中心-->
		<article>
			<div class="yanzheng bgbai top20 overflow">
				<span class="fl h3 lancolor" style="line-height: 7.73vw;">培训名称：</span>
				<form class="fl jiaoyu">
					<input class="fl h3 liu" type="text" />
					<select style="margin-left: 1.2vw;" class="fl h2 liu">
						<option>
							是否达标
						</option>
						<option>
							已达标
						</option>
						<option>
							未达标
						</option>
					</select>
					<button style="margin-left: 1.2vw;" class="fr h3 liu" id="chaxun">查询</button>
				</form>
			</div>
			<!--搜索结果-->
			<div class="yanzhengbo top20">
				<div class="title">
					<span class="fl h2">搜索结果</span>
				</div>
				@foreach($pro as $k=>$v)
				<div style="padding:0 2.4vw" class="shiti top20 bgbai xiazais">
					<table class="wbai top20">
						<thead>
							<td class="h3 lancolor">
								名称
							</td>
							<td class="h3 lancolor textcenter">
								学时年度
							</td>
							<td class="h3 lancolor textcenter">
								是否达标
							</td>
							<td class="h3 lancolor textcenter">
								达标时间
							</td>
						</thead>
						<tbody>
							<tr>
								<td class="h4 liu">{{$v->pname}}</td>
								<td class="h4 liu textcenter">{{date('Y')}}</td>
								<td class="h4 liu textcenter">@if($v->value>=60)是@else否@endif</td>
								<td class="h4 liu textcenter">{{date('Y.m.d',strtotime($v->time))}}</td>
							</tr>
							{{--<tr>--}}
								{{--<td style="padding:1vw 0vw;" colspan="4">--}}
									{{--<a class="fr cuoti h3 xiazai" href="">下载证书</a>--}}
								{{--</td>--}}
							{{--</tr>--}}
						</tbody>
					</table>
				</div>
				@endforeach
			</div>
			<!--搜索结果-->
		</article>
		<!--个人中心-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script>
			$(function(){
				$("#chaxun").click(function(){
					var value = $(this).prev("input").val();
					if(value == ""){
						layer.open({
					       content: '请输入培训名称',
					       skin: 'msg',
					       time: 2 //2秒后自动关闭
					    });
					    return false;
					};
				});
			});
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>