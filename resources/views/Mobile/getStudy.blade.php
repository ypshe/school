<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>报名培训</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">报名培训</h3>
		</div>
		<!--头部-->
		<!--报名培训-->
		<article>
			<div class="peixuntops top20 bgbai overflow">
				<span class="fl h2 lancolor">请选择继续教育科目</span>
				<select class="fl jiu h2 textcenter" id="select">
					<option value="0">请选择 </option>
					@foreach($pros as $k=>$v)
						<option value="{{$v->id}}">
							{{$v->name}}
						</option>
					@endforeach
				</select>
			</div>
			<script>
				$('#select').change(function(){
				    if($(this).val()!=='0'){
				        location.href='/wap/getStudy/'+$(this).val();
					}
				});
			</script>
			@if(isset($pro))
			<div class="jianjies bgbai top20" style="padding-top: 2.6vw;">
				<div class="title">
					<span>科目简介</span>
				</div>
				<div class="jianjieboxs overflow">
					<a class="overflow" href="">
						<img class="fl" src="/mobile/img/kecheng.jpg">
						<div class="fl" style="margin-left: 2.6vw;width:60.2vw">
							<h2 class="h2 san">{{$pro->name}}</h2>
							<span class="overflow" style="margin-top:4vw;">
								<span class="fl h2 jiu">学时：{{$study_time}}</span>
								<span class="fr h4" style="color:#e70a2e">￥{{$pro->price}}</span>
							</span>
						</div>
					</a>
				</div>
			</div>
			<div class="jianjies bgbai top20" style="padding-top: 2.6vw;">
				<div class="title">
					<span>课程简介</span>
				</div>
				<div class="jianjieboxs overflow kechengjian">
					@foreach($study as $k=>$v)
						<a class="overflow h2 liu" href="">
							{{$v}}
						</a>
					@endforeach
				</div>
			</div>
			<div class="jianjies bgbai top20" style="padding-top: 2.6vw;">
				<div class="title">
					<span>支付方式</span>
				</div>
				<div class="jianjieboxs overflow kechengjian">
					<a class="overflow h2 liu" href="" style="padding:2vw 0">
						<img class="fl" style="width:4.2vw;margin-top:2vw;margin-right: 2.6vw;" src="/mobile/img/yinhangka.png">
						银联支付
						<img class="fr" style="width:2.6vw;margin-top:3vw" src="/mobile/img/xuanzhong.png">
					</a>
				</div>
			</div>
			@endif
		</article>
		<div class="jiesuan overflow bgbai">
			<span class="fl h2 liu">总价：<b>￥00.00(免费参加课程)</b></span>
			{{--<a href="javascript:;" id="que" class="fr h1 bai textcenter">立即报名</a>--}}
			<a href="{{url('/wap/confirmStudy/'.$pro->id)}}" class="fr h1 bai textcenter">立即报名</a>
		</div>
		<!--报名培训-->
		<script>
			var querenzhifu = '<div class="bgbai" id="querenzhifu" style="padding-top: 2.6vw;padding-bottom: 2.6vw;posiation:relative">'+
			    '<i class="iconfont icon-error guanbi jiu h1"></i>'+
				'<div class="title">'+
					'<span>确认付款</span>'+
				'</div>'+
				'<h2 class="textcenter top40" style="font-size:4.8vw;color:#e70a2e;">'+
					'￥88.00'+
				'</h2>'+
				'<img style="width:96%;margin:auto;margin-top:4vw;" src="/mobile/img/yinhang.jpg">'+
				'<a id="queren2" class="anniu textcenter bai h2" href="javascript:;">确认</a>'+
			'</div>';
			var chenggong = '<div class="bgbai textcenter" id="chenggong" style="padding-top: 2.6vw;padding-bottom: 2.6vw;height:50vw">'+
				'<i class="iconfont icon-success textcenter" style="color:#38b00e;font-size:8vw;display:block;margin-top:10vw"></i>'+
				'<h2 class="textcenter top20 h2 san">'+
					'订单支付成功'+
				'</h2>'+
				'<a class="anniu textcenter bai h2 top40" href="javascript:;">查看订单</a>'+
			'</div>';
			var shibai = '<div class="bgbai textcenter" id="shibai" style="padding-top: 2.6vw;padding-bottom: 2.6vw;">'+
				'<i class="iconfont icon-error textcenter" style="color:#e70a2e;font-size:8vw;display:block;margin-top:10vw"></i>'+
				'<h2 class="textcenter top20 h2 san">'+
					'订单支付失败'+
				'</h2>'+
				'<div class="annius overflow top40">'+
				'<a class="fl anniu textcenter bai h2" style="background: #c9c9c9 !important;margin-top: 0;" id="quxiaoyonghu" href="javascript:;">取消</a>'+
				'<a class="fr anniu textcenter bai h2" id="quedingyonghu" style="margin-top: 0;" href="javascript:;">我的订单</a>'+
			' </div>'+
			'</div>';
			$("#que").click(function(){
				layer.open({
			       content: querenzhifu,
			       skin: 'footer',
			    });
			    $("#queren2").click(function(){
					layer.open({
				       content: chenggong,
				       skin: 'footer',
				    });
				    return false;
				});
				$(".guanbi").click(function(){
					$(this).parents(".layui-m-layer").hide();
				})
			});
			
		</script>
		
	</body>

</html>