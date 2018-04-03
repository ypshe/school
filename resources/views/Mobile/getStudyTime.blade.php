<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>学时验证</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">学时验证</h3>
			<a class="iconfont icon-wo fr h1 bai b" href="{{url('/wap/user')}}" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--学时验证-->
		<article>
			<div class="yanzheng bgbai top20 overflow">
				<span class="fl h3 lancolor" style="line-height: 7.73vw;">身份证号：</span>
				<span class="fl">
					<input class="fl h3 liu" type="text" value="@if(isset($cardId)){{$cardId}}@endif" />
					<button class="fr h3 liu" id="chaxun">查询</button>
				</span>
			</div>
			<!--搜索结果-->
			<div class="yanzhengbo top20 bgbai">
				<div class="title">
					<span class="fl h2">搜索结果</span>
				</div>
				<div style="margin:auto 2.4vw">
					<table class="wbai top20">
						<thead>
							<td class="h3 san textcenter">
								日期
							</td>
							<td class="h3 san textcenter">
								姓名
							</td>
							<td class="h3 san textcenter">
								专业名称
							</td>
							<td class="h3 san textcenter">
								学时
							</td>
							<td class="h3 san textcenter">
								结果
							</td>
						</thead>
						<tbody>
							@if(isset($time))
								@foreach($time as $k=>$v)
									<tr>
										<td class="h4 liu textcenter">{{date('Y.d',strtotime($v->addTime))}}</td>
										<td class="h4 liu textcenter">{{$user->name}}</td>
										<td class="h4 liu textcenter">{{\App\Admin\Model\Profession::find($v->pid)->name}}</td>
										<td class="h4 liu textcenter">{{$v->time}}</td>
										<td class="h4 liu textcenter">@if($v->time==$v->allTime)通过@else未通过@endif</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
			<!--搜索结果-->
		</article>
		<!--学时验证-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
			$(function(){
				var sfz = /^\d{15}|\d{}18$/;//验证身份证
				$("#chaxun").click(function(){
					var value = $(this).prev("input").val();
					if(value === ""){
						layer.open({
					       content: '请输入身份证号码',
					       skin: 'msg',
					       time: 2 //2秒后自动关闭
					    });
					    return false;
					}
					if(!value.match(sfz)){
						layer.open({
					       content: '身份证输入不合法，请重新输入',
					       skin: 'msg',
					       time: 2 //2秒后自动关闭
					    });
					    return false;
					}
					location.href='/wap/getStudyTime'+'/'+value;
				})
			})
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>