<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>在线考试</title>
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
			<h3 class="sanwu bai textcenter">在线考试</h3>
			<a class="iconfont icon-wo fr h1 bai b" href="/wap/user" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--个人中心-->
		<article class="bgbai">
			<div class="dingdantops overflow">
				<a style="text-align: left;" class="fl w25 textcenter h2 san on" href="">
					在线考试
				</a>
				<a class="fl w25 textcenter h2 san" href="/wap/user/exam_history">
					考试记录
				</a>
			</div>
			<!--考试列表-->
			<div class="dingdanbos top20 zaixian">
				<div class="main">
					@foreach($pro as $k=>$v)
						<dl>
							<dd>
								<a class="overflow" href="{{url('/wap/user/exam/'.$v->id)}}">
									<img class="fl ddle lazy" src="{{img_local($v->pic)}}">
									<div class="fr ddri">
										<div class="h2 san">{{$v->name}}</div>
										<div class="overflow h4 jiu" style="padding-top: 18px">
											考试时间：{{$v->exam_time}}分钟
											<div class="red h2 bai textcenter" style="background-color:#03478f;float:right">立即进入</div>
										</div>
									</div>
								</a>
							</dd>
						</dl>
					@endforeach
				</div>
			</div>
		</article>
		<!--个人中心-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
			$(function(){
				//图片懒加载
				$("img.lazy").lazyload({effect: "fadeIn"});
				//上拉加载更多
			var flag = true;
			var page = 0;
			function addmore(){
				var divadd = '<div class="main">';
					page++;
					var zong = 10;//总页数
					if(page > zong){
						console.log("已经没有数据了呢");
						setTimeout(function(){
							
						},1000);
						return false;
					}else{
						console.log("正在加载中");
						$.ajax({
							type:'get',
							url:'paging',
							async: false, //同步
							data:{
								page:page
							},
							success:function(data){
								var shuju = JSON.parse(data);
								for(var i = 0; i < shuju.length; i++){
									divadd = '<dl>'+
						'<dd>'+
							'<a class="overflow" href="">'+
								'<img class="fl ddle" src="/mobile/img/kecheng.jpg">'+
								'<div class="fr ddri">'+
									'<div class="h2 san">畜禽营养与饲料加工技术</div>'+
									'<div class="overflow h4 jiu">'+
										'考试时间：45分钟'+
									'</div>'+
								'</div>'+
							'</a>'+
						'</dd>'+
					'</dl>';
								};
								divadd = divadd+'</div>';
								$(".dingdanbos").append(divadd);
							}
						});
				    }	
				}
			});
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>