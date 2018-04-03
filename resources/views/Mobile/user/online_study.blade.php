<!DOCTYPE html>
<html class="bgbai">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>在线学习</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body class="bgbai">
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="/wap/user">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">在线学习</h3>
			<a class="fr iconfont icon-wo bai h1 b" href="/wap/user" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--在线学习-->
		<article>
			<div class="dingdantops overflow">
				<a style="text-align: left;" class="fl w25 textcenter h2 san on" href="javascript:;">
					正在学习
				</a>
				{{--<a class="fl w25 textcenter h2 san" href="javascript:;">--}}
					{{--已经学习--}}
				{{--</a>--}}
			</div>
			<div class="onlinexuexi" style="display: block;">
				@if($profession)
					@foreach($profession as $k=>$v)
						<dl>
							<dt class="overflow">
								<span class="fl san h2">{{$v->name}}</span>
								<span class="fr jiu h1 b iconfont icon-xiajiantou"></span>
							</dt>
							@foreach($v['study'] as $vv)
								<dd class="top20" @if($k==0)style="display: block;"@endif>
									<a class="overflow" href="{{url('/wap/studyDesc/'.$vv->id)}}">
										<img class="fl" src="{{img_local($vv->pic)}}">
										<div class="fl xuexi">
											<span class="h2 liu">{{$vv->name}}</span>
											<span class="h2 jiu">学时：{{$vv->video_num}}</span>
										</div>
										<div class="fr huan">
											<div class="huantop">
												<div class="yuan">
													<div class="yuan_bl1"></div>
													<div class="yuan_text h2 san textcenter">{{$vv->width??0}}%</div>
												</div>
											</div>
											<span class="textcenter h2" style="color:#b5d5f6;margin-top:2vw;margin-left: -3vw;">已学习</span>
										</div>
									</a>
								</dd>
							@endforeach
						</dl>
					@endforeach
				@else
					您还没有参加任何专业课程的学习...<a href="{{url('/wap/pro')}}">点击选择学习专业课程</a>
				@endif
			</div>
			{{--<div class="onlinexuexi">--}}
				{{--<dl>--}}
					{{--<dt class="overflow">--}}
						{{--<span class="fl san h2">畜牧兽医</span>--}}
						{{--<span class="fr jiu h1 b iconfont icon-xiajiantou"></span>--}}
					{{--</dt>--}}
					{{--<dd class="top20" style="display: block;">--}}
						{{--<a class="overflow" href="">--}}
							{{--<img class="fl" src="/mobile/img/kecheng.jpg">--}}
							{{--<div class="fl xuexi">--}}
								{{--<span class="h2 liu">畜禽营养与饲料加工技术</span>--}}
								{{--<span class="h2 jiu">学时：24</span>--}}
							{{--</div>--}}
							{{--<div class="fr huan">--}}
								{{--<div class="huantop">--}}
									{{--<div class="huantopb h4 textcenter">--}}
										{{--100%--}}
									{{--</div>--}}
								{{--</div>--}}
								{{--<span class="textcenter h2" style="color:#b5d5f6;margin-top:1.06vw">已学习</span>--}}
							{{--</div>--}}
						{{--</a>--}}
					{{--</dd>--}}
				{{--</dl>--}}
				{{--<dl>--}}
					{{--<dt class="overflow">--}}
						{{--<span class="fl san h2">计算机网络技术</span>--}}
						{{--<span class="fr jiu h1 b iconfont icon-xiajiantou"></span>--}}
					{{--</dt>--}}
					{{--<dd class="top20">--}}
						{{--<a class="overflow" href="">--}}
							{{--<img class="fl" src="/mobile/img/kecheng.jpg">--}}
							{{--<div class="fl xuexi">--}}
								{{--<span class="h2 liu">畜禽营养与饲料加工技术</span>--}}
								{{--<span class="h2 jiu">学时：24</span>--}}
							{{--</div>--}}
							{{--<div class="fr huan">--}}
								{{--<div class="huantop">--}}
									{{--<div class="huantopb h4 textcenter">--}}
										{{--100%--}}
									{{--</div>--}}
								{{--</div>--}}
								{{--<span class="textcenter h2" style="color:#b5d5f6;margin-top:1.06vw">已学习</span>--}}
							{{--</div>--}}
						{{--</a>--}}
					{{--</dd>--}}
				{{--</dl>--}}
			{{--</div>--}}
		</article>
		<!--在线学习-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script>
			$(function(){
				$(".onlinexuexi dl dt").click(function(){
					$(this).parent("dl").children("dd").toggle();
//					$(this).children("span").eq(1).toggleClass("icon-shangjiantou");
//					$(this).children("span").eq(1).toggleClass("icon-xiajiantou");
				});
				$(".dingdantops a").click(function(){
					$(this).addClass("on").siblings().removeClass("on");
					var x = $(".dingdantops a").index(this);
					$(".onlinexuexi").hide();
					$(".onlinexuexi").eq(x).show();
				});
			})
			var val = [];
			var dushu = [];
			for(var i = 0; i < $(".yuan").length; i++){
				var value = $(".yuan").eq(i).children(".yuan_text").text();
				val.push(value);
				toPoint(val[i],i);
			}
			function toPoint(percent,i){
			    var str=percent.replace("%","");
			    str= str/100;
			    console.log(str);
			    var aa = str * 360;
			    var bl = parseInt(aa);  
			    var rotatenum = bl;
			    dushu.push(rotatenum);
		        if(dushu[i] > 180){
		        	var blhtml = '';  
			        rotatenum = bl - 180;  
			        blhtml += '<div class="yuan_bl2">';  
			        blhtml += '<div class="yuan_bl4" style="-webkit-transform:rotate(' + rotatenum + 'deg);transform:rotate(' + rotatenum + 'deg);"></div>';  
			        blhtml += '</div>';
			        $(".yuan").eq(i).children(".yuan_bl1").after(blhtml);
		        }else{
		        	var blhtml = '';  
			        blhtml += '<div class="yuan_bl3" style="-webkit-transform:rotate(' + rotatenum + 'deg);transform:rotate(' + rotatenum + 'deg);"></div>';  
			        $(".yuan").eq(i).children(".yuan_bl1").after(blhtml);
		        }
			}
			console.log(dushu);
		</script>
	</body>

</html>