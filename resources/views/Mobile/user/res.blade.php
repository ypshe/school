<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>考核情况</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
		<link rel="stylesheet" href="/mobile/css/LArea.css" />
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a> 
			<h3 class="sanwu bai textcenter">考核情况</h3>
		</div>
		<!--头部-->
		<!--考核情况-->
		<article>
			<div class="kaohe bgbai">
				<table>
					<thead>
						<td class="h2 lancolor">试题名称</td>
						<td class="h2 lancolor textcenter">考核标准值</td>
						<td class="h2 lancolor textcenter">考核当前最高值</td>
						<td class="h2 lancolor textcenter">是否达标</td>
					</thead>
					@foreach($pro as $k=>$v)
					<tr>
						<td class="h3 san">
							{{$v->pname}}
						</td>
						<td class="h3 san textcenter">
							100分
						</td>
						<td class="h3 san textcenter">
							{{$v->value}}分
						</td>
						<td class="h3 san textcenter">
							<i class="iconfont @if($v->value>=60)icon-dui @else icon-error @endif h1" style="color:@if($v->value>=60)#398f04 @else #e70a2e @endif"></i>
						</td>
					</tr>
						@endforeach
				</table>
			</div>
		</article>
		<!--考核情况-->
		<!--查看错题-->
		
		<!--查看错题-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
			var cuoti = '<div class="cuotibox bgbai" style="padding-top: 2.6vw;width:100%;min-height: 71.2vw;posiation:relative">'+
			'<i class="iconfont icon-error guanbi jiu h1"></i>'+
			'<div class="title">'+
				'<span>查看错题</span>'+
			'</div>'+
			'<table>'+
				'<thead>'+
					'<td class="h2 san" style="text-align:left">试卷名称</td>'+
					'<td class="h2 san textcenter">操作</td>'+
				'</thead>'+
				'<tbody>'+
					'<tr>'+
						'<td class="h2 jiu" style="text-align:left">'+
							'畜牧兽医'+
						'</td>'+
						'<td>'+
							'<a href="" class="h2 liu textcenter">答题情况</a>'+
						'</td>'+
					'</tr>'+
					'<tr>'+
						'<td class="h2 jiu" style="text-align:left">'+
							'计算机网络技术'+
						'</td>'+
						'<td>'+
							'<a href="" class="h2 liu textcenter">答题情况</a>'+
						'</td>'+
					'</tr>'+
				'</tbody>'+
			'</table>'+
		'</div>';
		    $(".cuoti").click(function(){
		    	layer.open({
			       content: cuoti,
			       skin: 'footer'
			    });
			    $(".guanbi").click(function(){
					$(this).parents(".layui-m-layer").hide();
				});
		    })
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>