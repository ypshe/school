<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>培训课程-详情</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/swiper.min.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="/wap/study/1/{{$study->pid}}">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">课程详情</h3>
			<a class="iconfont icon-wo fr h1 c9 b bai" style="font-size:7vw" href="{{url('/wap/user')}}"></a>
		</div>
		<!--头部--> 
		<!--培训课程详情-->
		<article style="padding-bottom: 12vw;">
			<div class="xqtop bgbai">
				<div class="xqtopdw wbai textcenter bai" style="font-size:4.6vw;">
					<span>{{$study->name}}</span>
				</div>
				<img class="wbai" src="{{img_local($study->pic)}}">
			</div>
			<div class="jianjie bgbai">
				<div class="title">
					<span>课程简介</span>
				</div>
				<div class="jianjieb top20">
					<h2 class="h2 san">{{$study->name}}</h2>
					<div class="h3 jiu textcenter top20 overflow">
						<span class="fl w32" style="text-align: left;">时长：@if($study->time>=3600){{floor($study->time/3600)}}小时{{floor($study->time/60)}}分@else{{floor($study->time/60)}}分{{floor($study->time%60)}}秒@endif</span>
						<span class="fl w32" style="border-left:1px solid #eeeeee;border-right:1px solid #eeeeee">人数:139</span>
						<span class="fl w32">评分：{{$study->grade}}</span>
					</div>
				</div>
				<div class="jianjiebox top20 overflow">
					<span class="liu h2">
						{{$study->desc}}
					</span>
					<a href="javascript:;" id="zhankai" class="fr h2 jiu bgbai">展开</a>
				</div>
			</div>
			<div class="mulu top20 bgbai" style="padding-top: 2.6vw;">
				<div class="title">
					<span>课程目录</span>
				</div>
				<div class="mulubox">
					@foreach($study->section as $k=>$v)
						<dl>
							<dt class="san h2 overflow">
								第{{$k+1}}章 {{$v}}
								<i class="fr iconfont icon-xiajiantou jiu h1"></i>
							</dt>
							<dd>
								@foreach($videos as $kk=>$vv)
									@if($vv->section==$k)
										<a href="{{url('/wap/video/'.$vv->id)}}" class="overflow on">
											<span class="h3 jiu fl">{{$k+1}}-{{$vv->sort}} {{$vv->name}}</span>
											<span class="h3 jiu fr">@if($vv->time>=3600){{floor($vv->time/3600)}}小时{{floor($vv->time/60)}}分@else{{floor($vv->time/60)}}分{{floor($vv->time%60)}}秒@endif</span>
										</a>
									@endif
								@endforeach
							</dd>
						</dl>
					@endforeach
				</div>
			</div>
			<div class="bgbai top20 wbai" style="position: fixed;left:0;bottom:0vw">
				<a href="@if($define===0){{url('/wap/videoFirst/'.$study->id)}}@else{{url('/wap/getStudy/'.$study->pid)}}@endif" class="wbai textcenter bai h1" style="background: #03478f;height:11vw;line-height: 11vw;">@if($define===0)开始学习@else立即报名@endif</a>
			</div>
		</article>
		<!--培训课程详情-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/swiper.min.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
			$(".mulubox dl dt").click(function(){
				$(this).children("i").toggleClass("icon-shangjiantou");
				$(this).children("i").toggleClass("icon-xiajiantou");
				$(this).next("dd").toggle();
				$(this).parent("dl").siblings().children("dd").hide();
			});
			$("#zhankai").click(function(){
				$(this).prev("span").parent(".jianjiebox").toggleClass("on");
				if($(this).prev("span").parent(".jianjiebox").hasClass("on")){
					$(".jianjiebox a").text("收起");
				}else{
					$(".jianjiebox a").text("展开");
				}
			})
		</script>
	</body>

</html>